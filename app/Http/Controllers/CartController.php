<?php

namespace App\Http\Controllers;

use App\Models\TemporaryOrder;
use App\Models\Menu;
use App\Models\MenuOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        $cartItems = TemporaryOrder::with(['menu', 'menuOption'])
            ->where('user_id', Auth::id())
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $total += ($item->menuOption->cost ?? 0) * $item->quantity;
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Thêm item vào giỏ hàng
     */
    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'menu_option_id' => 'required|exists:menu_options,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Kiểm tra xem item đã có trong cart chưa
        $existingItem = TemporaryOrder::where('user_id', Auth::id())
            ->where('menu_id', $request->menu_id)
            ->where('menu_option_id', $request->menu_option_id)
            ->first();

        if ($existingItem) {
            // Cập nhật quantity nếu đã có
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
            // Tạo mới
            TemporaryOrder::create([
                'user_id' => Auth::id(),
                'menu_id' => $request->menu_id,
                'menu_option_id' => $request->menu_option_id,
                'quantity' => $request->quantity,
                'remarks' => $request->remarks ?? null,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Đã thêm vào giỏ hàng!');
    }

    /**
     * Cập nhật quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = TemporaryOrder::where('user_id', Auth::id())
            ->findOrFail($id);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')
            ->with('success', 'Đã cập nhật giỏ hàng!');
    }

    /**
     * Xóa item khỏi giỏ hàng
     */
    public function remove($id)
    {
        $cartItem = TemporaryOrder::where('user_id', Auth::id())
            ->findOrFail($id);

        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Đã xóa khỏi giỏ hàng!');
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        TemporaryOrder::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}

