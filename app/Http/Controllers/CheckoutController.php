<?php

namespace App\Http\Controllers;

use App\Models\TemporaryOrder;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout
     */
    public function index()
    {
        $cartItems = TemporaryOrder::with(['menu', 'menuOption'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống!');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += ($item->menuOption->cost ?? 0) * $item->quantity;
        }

        // Lấy danh sách bàn trống
        $availableTables = Table::where('status', 'available')->get();

        // Lấy payment methods (nếu có)
        try {
            $payments = Payment::with('bank')->get();
        } catch (\Exception $e) {
            $payments = collect();
        }

        return view('checkout.index', compact('cartItems', 'total', 'availableTables', 'payments'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'nullable|exists:tables,id',
            'payment_method' => 'nullable|string',
            'remarks' => 'nullable|string|max:500',
        ]);

        $cartItems = TemporaryOrder::with(['menu', 'menuOption'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        try {
            // Tạo transactions từ cart items
            foreach ($cartItems as $cartItem) {
                Transaction::create([
                    'user_id' => Auth::id(),
                    'table_id' => $request->table_id,
                    'menu_id' => $cartItem->menu_id,
                    'menu_option_id' => $cartItem->menu_option_id,
                    'quantity' => $cartItem->quantity,
                    'remarks' => $request->remarks ?? $cartItem->remarks,
                    'completion_status' => 'no',
                    'payment_status' => 'no',
                ]);
            }

            // Cập nhật table status nếu có chọn bàn
            if ($request->table_id) {
                Table::where('id', $request->table_id)
                    ->update(['status' => 'occupied']);
            }

            // Xóa cart
            TemporaryOrder::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('checkout.success')
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Trang xác nhận đặt hàng thành công
     */
    public function success()
    {
        return view('checkout.success');
    }
}

