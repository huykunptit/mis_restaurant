<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Menu;
use App\Models\MenuOption;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaffOrderController extends Controller
{
    /**
     * Màn hình chọn bàn
     */
    public function selectTable(Request $request)
    {
        $search = $request->get('search', '');
        $zoneFilter = $request->get('zone', '');

        $query = Table::query();

        // Search theo table_number
        if ($search) {
            $query->where('table_number', 'like', '%' . $search . '%');
        }

        // Filter theo zone
        if ($zoneFilter) {
            $query->where('zone', $zoneFilter);
        }

        $tables = $query->orderBy('zone')->orderBy('table_number')->get();

        // Group tables theo zone
        $tablesByZone = $tables->groupBy('zone');

        // Lấy danh sách zones
        $zones = Table::distinct()->pluck('zone')->filter()->sort()->values();

        // Tính toán trạng thái bàn
        foreach ($tables as $table) {
            // Đếm số đơn chưa thanh toán của bàn
            $unpaidOrders = Transaction::where('table_id', $table->id)
                ->where('payment_status', 'no')
                ->count();

            // Xác định trạng thái màu
            if ($table->status === 'available') {
                $table->status_color = 'success'; // Xanh - Trống
            } elseif ($table->status === 'occupied' && $unpaidOrders > 0) {
                $table->status_color = 'danger'; // Đỏ - Có đơn chưa thanh toán
            } elseif ($table->status === 'occupied') {
                $table->status_color = 'warning'; // Vàng - Có khách chưa đặt món
            } else {
                $table->status_color = 'secondary'; // Xám
            }

            $table->unpaid_orders_count = $unpaidOrders;
        }

        return view('staff.orders.select-table', compact('tablesByZone', 'zones', 'search', 'zoneFilter'));
    }

    /**
     * Màn hình đặt món nhanh
     */
    public function create(Request $request)
    {
        $tableId = $request->get('table_id');

        if (!$tableId) {
            return redirect()->route('staff.orders.select-table')
                ->with('error', 'Vui lòng chọn bàn');
        }

        $table = Table::findOrFail($tableId);

        // Lấy danh sách categories
        $categories = Category::orderBy('name')->get();

        // Lấy menu items theo category
        $menusByCategory = Menu::with(['menuOption', 'category'])
            ->where('disable', 'no')
            ->orderBy('name')
            ->get()
            ->groupBy('category_id');

        // Lấy đơn hiện tại của bàn (chưa thanh toán)
        $currentOrders = Transaction::with(['menu', 'menuOption'])
            ->where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->orderBy('created_at', 'desc')
            ->get();

        // Tính tổng tiền đơn hiện tại
        $currentTotal = 0;
        foreach ($currentOrders as $order) {
            $currentTotal += ($order->menuOption->cost ?? 0) * $order->quantity;
        }

        return view('staff.orders.create', compact(
            'table',
            'categories',
            'menusByCategory',
            'currentOrders',
            'currentTotal'
        ));
    }

    /**
     * Xử lý đặt món
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.menu_option_id' => 'required|exists:menu_options,id',
            'items.*.quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
        ]);

        $table = Table::findOrFail($request->table_id);
        $staffId = Auth::id();

        // Tạo order_group_id (unique cho mỗi lần đặt món)
        $orderGroupId = 'ORD-' . Str::upper(Str::random(8)) . '-' . time();

        DB::beginTransaction();
        try {
            // Tạo transactions cho từng item
            foreach ($request->items as $item) {
                Transaction::create([
                    'user_id' => null, // Khách hàng không cần đăng nhập
                    'staff_id' => $staffId,
                    'table_id' => $table->id,
                    'order_group_id' => $orderGroupId,
                    'menu_id' => $item['menu_id'],
                    'menu_option_id' => $item['menu_option_id'],
                    'quantity' => $item['quantity'],
                    'remarks' => $request->remarks ?? '',
                    'completion_status' => 'no',
                    'payment_status' => 'no',
                ]);
            }

            // Cập nhật trạng thái bàn
            if ($table->status === 'available') {
                $table->status = 'occupied';
                $table->save();
            }

            DB::commit();

            // Gửi real-time notification về admin
            $this->sendNewOrderNotification($table, $orderGroupId);

            return redirect()->route('staff.orders.table', $table->id)
                ->with('success', 'Đặt món thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Màn hình quản lý đơn theo bàn
     */
    public function table($tableId)
    {
        $table = Table::findOrFail($tableId);

        // Lấy tất cả đơn của bàn (chưa thanh toán), group theo order_group_id
        $orders = Transaction::with(['menu', 'menuOption', 'staff'])
            ->where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('order_group_id');

        // Tính tổng tiền theo từng order group
        $orderGroups = [];
        foreach ($orders as $groupId => $groupOrders) {
            $total = 0;
            $completedCount = 0;
            $totalCount = $groupOrders->count();

            foreach ($groupOrders as $order) {
                $total += ($order->menuOption->cost ?? 0) * $order->quantity;
                if ($order->completion_status === 'yes') {
                    $completedCount++;
                }
            }

            $orderGroups[] = [
                'group_id' => $groupId,
                'orders' => $groupOrders,
                'total' => $total,
                'completed_count' => $completedCount,
                'total_count' => $totalCount,
                'created_at' => $groupOrders->first()->created_at,
            ];
        }

        // Sắp xếp theo thời gian (mới nhất trước)
        usort($orderGroups, function($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        // Tổng tiền tất cả đơn
        $grandTotal = array_sum(array_column($orderGroups, 'total'));

        // Kiểm tra tất cả món đã giao chưa
        $allCompleted = true;
        foreach ($orderGroups as $group) {
            if ($group['completed_count'] < $group['total_count']) {
                $allCompleted = false;
                break;
            }
        }

        return view('staff.orders.table', compact(
            'table',
            'orderGroups',
            'grandTotal',
            'allCompleted'
        ));
    }

    /**
     * Send new order notification
     */
    private function sendNewOrderNotification($table, $orderGroupId)
    {
        // Tạo notification
        \App\Models\Notification::create([
            'user_id' => null, // null = gửi cho tất cả admin
            'type' => 'new_order',
            'title' => 'Đơn hàng mới',
            'message' => "Bàn {$table->table_number} ({$table->zone}) có đơn hàng mới",
            'related_type' => 'table',
            'related_id' => $table->id,
            'is_read' => false,
        ]);

        // Broadcast event với Redis
        $firstOrder = Transaction::where('order_group_id', $orderGroupId)->first();
        if ($firstOrder) {
            event(new \App\Events\NewOrderCreated($firstOrder));
        }
    }
}

