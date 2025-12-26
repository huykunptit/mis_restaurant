<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function dashboard()
    {
        // Statistics for dashboard
        $totalOrders = Transaction::where('payment_status', 'no')->count();
        $pendingOrders = Transaction::where('completion_status', 'no')
            ->where('payment_status', 'no')
            ->count();
        $completedOrders = Transaction::where('completion_status', 'yes')
            ->where('payment_status', 'no')
            ->count();
        
        // Calculate total revenue from paid orders
        $totalRevenue = Transaction::where('payment_status', 'yes')
            ->join('menu_options', 'transactions.menu_option_id', '=', 'menu_options.id')
            ->selectRaw('SUM(menu_options.cost * transactions.quantity) as total')
            ->value('total') ?? 0;
        
        // Today's revenue
        $todayRevenue = Transaction::where('payment_status', 'yes')
            ->whereDate('updated_at', today())
            ->join('menu_options', 'transactions.menu_option_id', '=', 'menu_options.id')
            ->selectRaw('SUM(menu_options.cost * transactions.quantity) as total')
            ->value('total') ?? 0;
        
        // Total users
        $totalUsers = User::count();
        $customerRole = \App\Models\Role::where('name', 'customer')->first();
        $staffRole = \App\Models\Role::where('name', 'employee')->first();
        $totalCustomers = $customerRole ? User::where('role_id', $customerRole->id)->count() : 0;
        $totalStaff = $staffRole ? User::where('role_id', $staffRole->id)->count() : 0;
        
        // Total menu items
        $totalMenuItems = Menu::count();
        $activeMenuItems = Menu::where('disable', 'no')->count();
        
        // Recent orders (last 10)
        $recentOrders = Transaction::with(['user', 'menu', 'menuOption', 'table'])
            ->where('payment_status', 'no')
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();

        return view('admin.home', [
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'completedOrders' => $completedOrders,
            'totalRevenue' => $totalRevenue,
            'todayRevenue' => $todayRevenue,
            'totalUsers' => $totalUsers,
            'totalCustomers' => $totalCustomers,
            'totalStaff' => $totalStaff,
            'totalMenuItems' => $totalMenuItems,
            'activeMenuItems' => $activeMenuItems,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function index(Request $request)
    {   
        // Get filter parameters
        $filter = $request->get('filter', 'unpaid'); // unpaid, completed
        $dateFilter = $request->get('date', null); // YYYY-MM-DD format
        $search = $request->get('search', ''); // Search query
        
        // Build query based on filter - Query by Table instead of User
        if ($filter === 'completed') {
            // Completed orders: payment_status = 'yes' AND completion_status = 'yes'
            $query = Table::select('id', 'table_number', 'zone', 'status')
                ->with([
                    'transactions' => function($q) use ($dateFilter) {
                        $q->select('id', 'user_id', 'staff_id', 'table_id', 'menu_id', 'menu_option_id', 'quantity', 'payment_status', 'completion_status', 'created_at', 'updated_at', 'order_group_id')
                              ->where('payment_status', 'yes')
                              ->where('completion_status', 'yes');
                        if ($dateFilter) {
                            $q->whereDate('updated_at', $dateFilter);
                        }
                    },
                    'transactions.menuOption:id,cost',
                    'transactions.menu:id,name,category_id',
                    'transactions.menu.category:id,name',
                    'transactions.staff:id,first_name,last_name',
                    'transactions.user:id,first_name,last_name',
                ])
                ->whereHas('transactions', function($q) use ($dateFilter) {
                    $q->where('payment_status', 'yes')
                          ->where('completion_status', 'yes');
                    if ($dateFilter) {
                        $q->whereDate('updated_at', $dateFilter);
                    }
                });
            
            // Add search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('table_number', 'like', '%' . $search . '%')
                      ->orWhere('zone', 'like', '%' . $search . '%')
                      ->orWhereRaw("CONCAT(COALESCE(zone, ''), ' - Bàn ', table_number) LIKE ?", ['%' . $search . '%']);
                });
            }
            
            $filledTables = $query->paginate(15)->appends($request->query());
        } else {
            // Unpaid orders: payment_status = 'no'
            $query = Table::select('id', 'table_number', 'zone', 'status')
                ->with([
                    'transactions' => function($q) use ($dateFilter) {
                        $q->select('id', 'user_id', 'staff_id', 'table_id', 'menu_id', 'menu_option_id', 'quantity', 'payment_status', 'completion_status', 'created_at', 'updated_at', 'order_group_id')
                              ->where('payment_status', 'no');
                        if ($dateFilter) {
                            $q->whereDate('created_at', $dateFilter);
                        }
                    },
                    'transactions.menuOption:id,cost',
                    'transactions.menu:id,name,category_id',
                    'transactions.menu.category:id,name',
                    'transactions.staff:id,first_name,last_name',
                    'transactions.user:id,first_name,last_name',
                ])
                ->whereHas('transactions', function($q) use ($dateFilter) {
                    $q->where('payment_status', 'no');
                    if ($dateFilter) {
                        $q->whereDate('created_at', $dateFilter);
                    }
                });
            
            // Add search functionality
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('table_number', 'like', '%' . $search . '%')
                      ->orWhere('zone', 'like', '%' . $search . '%')
                      ->orWhereRaw("CONCAT(COALESCE(zone, ''), ' - Bàn ', table_number) LIKE ?", ['%' . $search . '%']);
                });
            }
            
            $filledTables = $query->paginate(15)->appends($request->query());
        }

        // Transform Table objects to match view expectations (with order relationship)
        $filledTables->getCollection()->transform(function($table) {
            // Create a mock object that has 'order' relationship pointing to transactions
            $table->order = $table->transactions;
            // Add first_name and last_name for compatibility with view
            $firstTransaction = $table->transactions->first();
            if ($firstTransaction && $firstTransaction->user) {
                $table->first_name = $firstTransaction->user->first_name;
                $table->last_name = $firstTransaction->user->last_name;
            } else {
                // If no user, show as "Khách vãng lai"
                $table->first_name = 'Khách';
                $table->last_name = 'vãng lai';
            }
            return $table;
        });

        return view('order.index', [
            'filledTables' => $filledTables,
            'filter' => $filter,
            'dateFilter' => $dateFilter,
            'search' => $search,
        ]);
    }

    public function complete($id)
    {
        // $id can be table_id (new system) or user_id (old system)
        // Try table_id first
        $table = Table::find($id);
        
        if ($table) {
            // New system: update by table_id
            $updated = Transaction::where('table_id', $id)
                ->where('completion_status', 'no')
                ->where('payment_status', 'no')
                ->update(['completion_status' => 'yes']);

            if ($updated > 0) {
                return redirect()
                    ->route('orders.admin')
                    ->with('success', "Đã đánh dấu {$updated} món hoàn thành");
            }

            $totalPending = Transaction::where('table_id', $id)
                ->where('payment_status', 'no')
                ->where('completion_status', 'no')
                ->count();

            if ($totalPending == 0) {
                return redirect()
                    ->route('orders.admin')
                    ->with('info','Tất cả món đã được hoàn thành rồi');
            }
        } else {
            // Old system: update by user_id
            $user = User::find($id);
            if ($user) {
                $updated = Transaction::where('user_id', $id)
                    ->where('completion_status', 'no')
                    ->where('payment_status', 'no')
                    ->update(['completion_status' => 'yes']);

                if ($updated > 0) {
                    return redirect()
                        ->route('orders.admin')
                        ->with('success', "Đã đánh dấu {$updated} món hoàn thành");
                }

                $totalPending = Transaction::where('user_id', $id)
                    ->where('payment_status', 'no')
                    ->where('completion_status', 'no')
                    ->count();

                if ($totalPending == 0) {
                    return redirect()
                        ->route('orders.admin')
                        ->with('info','Tất cả món đã được hoàn thành rồi');
                }
            }
        }

        return redirect()
            ->route('orders.admin')
            ->with('error','Không có đơn hàng nào cần hoàn thành');
    }

    public function paid($id)
    {
        // $id can be table_id (new system) or user_id (old system)
        // Try table_id first
        $table = Table::find($id);
        
        if ($table) {
            // New system: check and update by table_id
            // Allow early payment (no need to wait for all items)
            $unpaidOrders = Transaction::where('table_id', $id)
                ->where('payment_status', 'no')
                ->count();

            if ($unpaidOrders == 0) {
                return redirect()
                    ->route('orders.admin')
                    ->with('info','Tất cả đơn hàng đã được thanh toán rồi');
            }

            // Update all unpaid orders to paid
            $updated = Transaction::where('table_id', $id)
                ->where('payment_status', 'no')
                ->update([
                    'payment_status' => 'yes',
                ]);

            if ($updated > 0) {
                // Update table status
                $table->status = 'available';
                $table->save();
                
                return redirect()
                    ->route('orders.admin')
                    ->with('success', "Đã thanh toán {$updated} món");
            }
        } else {
            // Old system: check and update by user_id
            $user = User::find($id);
            if ($user) {
                $uncompletedOrders = Transaction::where('user_id', $id)
                    ->where('payment_status', 'no')
                    ->where('completion_status', 'no')
                    ->count();

                if ($uncompletedOrders > 0) {
                    return redirect()
                        ->route('orders.admin')
                        ->with('error','Vui lòng hoàn thành tất cả món trước khi thanh toán');
                }

                // Update all unpaid orders to paid
                $updated = Transaction::where('user_id', $id)
                    ->where('payment_status', 'no')
                    ->update([
                        'payment_status' => 'yes',
                        'completion_status' => 'yes',
                    ]);

                if ($updated > 0) {
                    return redirect()
                        ->route('orders.admin')
                        ->with('success', "Đã thanh toán {$updated} món");
                }

                // Check if already paid
                $unpaidOrders = Transaction::where('user_id', $id)
                    ->where('payment_status', 'no')
                    ->count();

                if ($unpaidOrders == 0) {
                    return redirect()
                        ->route('orders.admin')
                        ->with('info','Tất cả đơn hàng đã được thanh toán rồi');
                }
            }
        }

        return redirect()
            ->route('orders.admin')
            ->with('error','Không có đơn hàng nào cần thanh toán');
    }

    public function show($id)
    {
        // $id can be either table_id or user_id (for backward compatibility)
        // Try to find as table first (new system)
        $table = Table::find($id);
        
        if ($table) {
            // New system: orders grouped by table
            $orders = Transaction::with(['menu', 'menu.category', 'menuOption', 'table', 'staff', 'user'])
                ->where('table_id', $id)
                ->where('payment_status', 'no')
                ->get()
                ->groupBy('order_group_id');
            
            // Calculate completion stats
            $allOrders = Transaction::where('table_id', $id)
                ->where('payment_status', 'no')
                ->get();
            $totalOrders = $allOrders->count();
            $completedOrders = $allOrders->where('completion_status', 'yes')->count();
            $allCompleted = $totalOrders > 0 && $completedOrders == $totalOrders;
            
            // Find remarks
            $remark = Transaction::where('table_id', $id)
                ->where('payment_status', 'no')
                ->where('remarks', '<>', '')
                ->whereNotNull('remarks')
                ->first();
            
            // Create a mock user object for view compatibility
            $user = (object)[
                'id' => $table->id,
                'first_name' => $table->zone ? $table->zone : 'Bàn',
                'last_name' => $table->table_number,
                'table' => $table,
            ];
            
            return view('order.show', [
                'user' => $user,
                'orders' => $allOrders, // Flatten for view compatibility
                'orderGroups' => $orders, // Grouped orders
                'remark' => $remark,
                'totalOrders' => $totalOrders,
                'completedOrders' => $completedOrders,
                'allCompleted' => $allCompleted,
                'table' => $table,
            ]);
        } else {
            // Old system: orders by user_id (backward compatibility)
            $user = User::with('role')->findOrFail($id);
        
            // Get orders associated with the user
            $orders = Transaction::with(['menu', 'menu.category', 'menuOption', 'table'])
                ->where('user_id', $id)
                ->where('payment_status', 'no')
                ->get();
        
            // Calculate completion stats
            $totalOrders = $orders->count();
            $completedOrders = $orders->where('completion_status', 'yes')->count();
            $allCompleted = $totalOrders > 0 && $completedOrders == $totalOrders;
        
            // Find remarks for any orders associated with the user
            $remark = Transaction::where('user_id', $id)
                ->where('payment_status', 'no')
                ->where('remarks', '<>', '')
                ->whereNotNull('remarks')
                ->first();
        
            return view('order.show', [
                'user' => $user,
                'orders' => $orders,
                'remark' => $remark,
                'totalOrders' => $totalOrders,
                'completedOrders' => $completedOrders,
                'allCompleted' => $allCompleted,
            ]);
        }
    }
    
    public function completeSingleOrder($id)
    {
        $order = Transaction::findOrFail($id);
        $order->completion_status = "yes";
        $order->save();

        // Use table_id if available (new system), otherwise use user_id (old system)
        $redirectId = $order->table_id ?? $order->user_id;
        
        if (!$redirectId) {
            return redirect()
                ->route('orders.admin')
                ->with('success','Món đã được đánh dấu hoàn thành');
        }

        return redirect()
            ->route('order.show', $redirectId)
            ->with('success','Món đã được đánh dấu hoàn thành');
    }

    public function cancelSingleOrder($id)
    {
        $order = Transaction::findOrFail($id);
        
        // Use table_id if available (new system), otherwise use user_id (old system)
        $redirectId = $order->table_id ?? $order->user_id;
        
        $order->delete();

        if (!$redirectId) {
            return redirect()
                ->route('orders.admin')
                ->with('success','Món đã được hủy');
        }

        return redirect()
            ->route('order.show', $redirectId)
            ->with('success','Món đã được hủy');
    }


    


}