<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Hiển thị lịch sử đơn hàng của customer
     */
    public function index()
    {
        $orders = Transaction::with(['menu', 'menuOption', 'table'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Transaction::with(['menu', 'menuOption', 'table'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.order-detail', compact('order'));
    }
}

