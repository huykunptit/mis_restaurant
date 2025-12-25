<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Danh sách ca làm việc
     */
    public function index()
    {
        $shifts = Shift::orderBy('start_time')->paginate(15);
        return view('admin.shifts.index', compact('shifts'));
    }

    /**
     * Tạo ca làm việc mới
     */
    public function create()
    {
        return view('admin.shifts.create');
    }

    /**
     * Lưu ca làm việc mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Shift::create([
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Thêm ca làm việc thành công!');
    }

    /**
     * Sửa ca làm việc
     */
    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('admin.shifts.edit', compact('shift'));
    }

    /**
     * Cập nhật ca làm việc
     */
    public function update(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $shift->name = $request->name;
        $shift->start_time = $request->start_time;
        $shift->end_time = $request->end_time;
        $shift->description = $request->description;
        $shift->is_active = $request->has('is_active') ? true : false;
        $shift->save();

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Cập nhật ca làm việc thành công!');
    }

    /**
     * Xóa ca làm việc
     */
    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);

        // Kiểm tra xem có nhân viên nào đang dùng ca này không
        if ($shift->users()->count() > 0) {
            return redirect()
                ->route('admin.shifts.index')
                ->with('error', 'Không thể xóa ca làm việc này vì đang có nhân viên sử dụng!');
        }

        $shift->delete();

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Xóa ca làm việc thành công!');
    }
}

