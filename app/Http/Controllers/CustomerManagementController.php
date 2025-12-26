<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerManagementController extends Controller
{
    /**
     * Danh sách khách hàng
     */
    public function index(Request $request)
    {
        $customerRole = Role::whereIn('name', ['customer', 'guest'])->first();
        if (!$customerRole) {
            abort(404, 'Customer role not found');
        }
        
        $query = User::with(['role'])
            ->where('role_id', $customerRole->id);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Tạo khách hàng mới
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Lưu khách hàng mới
     */
    public function store(Request $request)
    {
        $customerRole = Role::whereIn('name', ['customer', 'guest'])->first();
        if (!$customerRole) {
            abort(404, 'Customer role not found');
        }

        $request->validate([
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email',
            'password' => 'required|string|min:6|max:200',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $customerRole->id,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Thêm khách hàng thành công!');
    }

    /**
     * Sửa khách hàng
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        
        // Kiểm tra là customer
        $customerRole = Role::whereIn('name', ['customer', 'guest'])->first();
        if (!$customerRole || $customer->role_id !== $customerRole->id) {
            abort(403);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Cập nhật khách hàng
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        
        // Kiểm tra là customer
        $customerRole = Role::whereIn('name', ['customer', 'guest'])->first();
        if (!$customerRole || $customer->role_id !== $customerRole->id) {
            abort(403);
        }

        $rules = [
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email,' . $id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|max:200';
        }

        $request->validate($rules);

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;

        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }

        $customer->save();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Cập nhật khách hàng thành công!');
    }

    /**
     * Xóa khách hàng
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        
        // Kiểm tra là customer
        $customerRole = Role::whereIn('name', ['customer', 'guest'])->first();
        if (!$customerRole || $customer->role_id !== $customerRole->id) {
            abort(403);
        }

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Xóa khách hàng thành công!');
    }
}

