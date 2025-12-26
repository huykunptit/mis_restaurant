<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffManagementController extends Controller
{
    /**
     * Danh sách nhân viên
     */
    public function index(Request $request)
    {
        $staffRole = Role::where('name', 'employee')->first();
        
        if (!$staffRole) {
            abort(404, 'Staff role not found');
        }
        
        $query = User::with(['role', 'shift'])
            ->where('role_id', $staffRole->id);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter by shift
        if ($request->filled('shift_id')) {
            $query->where('shift_id', $request->shift_id);
        }

        $staffs = $query->orderBy('created_at', 'desc')->paginate(15);
        $shifts = Shift::where('is_active', true)->orderBy('start_time')->get();

        return view('admin.staffs.index', compact('staffs', 'shifts'));
    }

    /**
     * Tạo nhân viên mới
     */
    public function create()
    {
        $shifts = Shift::where('is_active', true)->orderBy('start_time')->get();
        return view('admin.staffs.create', compact('shifts'));
    }

    /**
     * Lưu nhân viên mới
     */
    public function store(Request $request)
    {
        $staffRole = Role::where('name', 'employee')->first();
        
        if (!$staffRole) {
            abort(404, 'Staff role not found');
        }

        $request->validate([
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email',
            'password' => 'required|string|min:6|max:200',
            'shift_id' => 'nullable|exists:shifts,id',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $staffRole->id,
            'shift_id' => $request->shift_id,
        ]);

        return redirect()
            ->route('admin.staffs.index')
            ->with('success', 'Thêm nhân viên thành công!');
    }

    /**
     * Sửa nhân viên
     */
    public function edit($id)
    {
        $staff = User::with('shift')->findOrFail($id);
        
        // Kiểm tra là staff
        $staffRole = Role::where('name', 'employee')->first();
        if (!$staffRole || $staff->role_id !== $staffRole->id) {
            abort(403);
        }

        $shifts = Shift::where('is_active', true)->orderBy('start_time')->get();

        return view('admin.staffs.edit', compact('staff', 'shifts'));
    }

    /**
     * Cập nhật nhân viên
     */
    public function update(Request $request, $id)
    {
        $staff = User::findOrFail($id);
        
        // Kiểm tra là staff
        $staffRole = Role::where('name', 'employee')->first();
        if (!$staffRole || $staff->role_id !== $staffRole->id) {
            abort(403);
        }

        $rules = [
            'first_name' => 'required|string|max:200',
            'last_name' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email,' . $id,
            'shift_id' => 'nullable|exists:shifts,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|max:200';
        }

        $request->validate($rules);

        $staff->first_name = $request->first_name;
        $staff->last_name = $request->last_name;
        $staff->email = $request->email;
        $staff->shift_id = $request->shift_id;

        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->save();

        return redirect()
            ->route('admin.staffs.index')
            ->with('success', 'Cập nhật nhân viên thành công!');
    }

    /**
     * Xóa nhân viên
     */
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        
        // Kiểm tra là staff
        $staffRole = Role::where('name', 'employee')->first();
        if (!$staffRole || $staff->role_id !== $staffRole->id) {
            abort(403);
        }

        $staff->delete();

        return redirect()
            ->route('admin.staffs.index')
            ->with('success', 'Xóa nhân viên thành công!');
    }
}

