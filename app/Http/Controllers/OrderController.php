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
        $totalCustomers = User::where('role_id', 3)->count();
        $totalStaff = User::where('role_id', 2)->count();
        
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

    public function index()
    {   
        $filledTables = User::with([
                'order' => function($query) {
                    $query->where('payment_status', 'no');
                },
                'order.menuOption',
                'order.menu',
                'order.menu.category',
                'role'
            ])
            ->where('role_id', '3')
            ->whereHas('order', function($query) {
                $query->where('payment_status', 'no');
            })
            ->get();

        return view('order.index', [
            'filledTables' => $filledTables,
        ]);
    }

    public function complete($id)
    {
        $updated = Transaction::where('user_id', $id)
            ->where('completion_status', 'no')
            ->update(['completion_status' => 'yes']);

        if ($updated > 0) {
            $route = auth()->user()->hasRole('admin') ? 'home.admin' : 'home.staff';
            return redirect()
                ->route($route)
                ->with('success','Order successfully marked as completed');
        }

        $route = auth()->user()->hasRole('admin') ? 'home.admin' : 'home.staff';
        return redirect()
            ->route($route)
            ->with('error','No pending orders found to complete');
    }

    public function paid($id)
    {
        $updated = Transaction::where('table_id', $id)
            ->where('payment_status', 'no')
            ->update([
                'payment_status' => 'yes',
                'completion_status' => 'yes',
            ]);

        if ($updated > 0) {
            $route = auth()->user()->hasRole('admin') ? 'home.admin' : 'home.staff';
            return redirect()
                ->route($route)
                ->with('success','Order successfully marked as paid');
        }

        $route = auth()->user()->hasRole('admin') ? 'home.admin' : 'home.staff';
        return redirect()
            ->route($route)
            ->with('error','No unpaid orders found');
    }

    public function show($tableId)
    {
        // Find the table
        $table = Table::findOrFail($tableId);
    
        // Get orders associated with the table
        $orders = Transaction::with(['menu', 'menu.category', 'menuOption'])
            ->where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->get();
    
        // Find remarks for any orders associated with the table
        $remark = Transaction::where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->where('remarks', '<>', '')
            ->first();
    
        return view('order.show', [
            'table' => $table,
            'orders' => $orders,
            'remark' => $remark,
        ]);
    }
    
    public function completeSingleOrder($id)
    {
        $order = Transaction::findOrFail($id);
        $order->completion_status = "yes";
        $order->save();

        return redirect()
            ->route('order.show', $order->table_id)
            ->with('success','Order successfully marked as complete');
    }

    public function cancelSingleOrder($id)
    {
        $order = Transaction::findOrFail($id);
        $tableId = $order->table_id;
        $order->delete();

        return redirect()
            ->route('order.show', $tableId)
            ->with('success','Order successfully canceled');
    }


    


}