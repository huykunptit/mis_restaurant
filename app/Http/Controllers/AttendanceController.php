<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Danh sách chấm công
     */
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'shift']);

        // Filter by staff
        if ($request->filled('staff_id')) {
            $query->where('user_id', $request->staff_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('work_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('work_date', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('work_date', 'desc')
            ->orderBy('user_id')
            ->paginate(20);

        $staffs = User::whereHas('role', function($q) {
            $q->where('name', 'employee');
        })->orderBy('first_name')->get();

        return view('admin.attendances.index', compact('attendances', 'staffs'));
    }

    /**
     * Báo cáo chấm công
     */
    public function report(Request $request)
    {
        $query = Attendance::with(['user', 'shift']);

        // Filter by staff
        if ($request->filled('staff_id')) {
            $query->where('user_id', $request->staff_id);
        }

        // Filter by date range (default: current month)
        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->endOfMonth()->format('Y-m-d');
        
        $query->whereDate('work_date', '>=', $dateFrom)
              ->whereDate('work_date', '<=', $dateTo);

        $attendances = $query->orderBy('work_date', 'desc')->get();

        // Group by user and calculate statistics
        $reportData = [];
        foreach ($attendances->groupBy('user_id') as $userId => $userAttendances) {
            $user = $userAttendances->first()->user;
            $totalDays = $userAttendances->count();
            $presentDays = $userAttendances->where('status', 'present')->count();
            $lateDays = $userAttendances->where('status', 'late')->count();
            $earlyLeaveDays = $userAttendances->where('status', 'early_leave')->count();
            $absentDays = $userAttendances->where('status', 'absent')->count();
            
            // Calculate average check-in/check-out times
            $avgCheckInLate = $userAttendances->whereNotNull('check_in_late_minutes')
                ->avg('check_in_late_minutes') ?? 0;
            $avgCheckOutEarly = $userAttendances->whereNotNull('check_out_early_minutes')
                ->avg('check_out_early_minutes') ?? 0;

            $reportData[] = [
                'user' => $user,
                'total_days' => $totalDays,
                'present_days' => $presentDays,
                'late_days' => $lateDays,
                'early_leave_days' => $earlyLeaveDays,
                'absent_days' => $absentDays,
                'avg_check_in_late' => round($avgCheckInLate, 1),
                'avg_check_out_early' => round($avgCheckOutEarly, 1),
                'attendances' => $userAttendances,
            ];
        }

        $staffs = User::whereHas('role', function($q) {
            $q->where('name', 'employee');
        })->orderBy('first_name')->get();

        return view('admin.attendances.report', compact('reportData', 'staffs', 'dateFrom', 'dateTo'));
    }

    /**
     * Check-in (tự động khi đăng nhập)
     */
    public function checkIn($userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : Auth::user();
        
        // Kiểm tra xem có phải staff không
        if (!$user->hasRole('staff')) {
            return response()->json(['error' => 'Chỉ nhân viên mới được check-in'], 403);
        }

        $today = Carbon::today();
        
        // Kiểm tra xem đã check-in chưa
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('work_date', $today)
            ->first();

        if ($attendance && $attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã check-in hôm nay rồi',
            ]);
        }

        // Tạo hoặc cập nhật attendance
        if (!$attendance) {
            $attendance = Attendance::create([
                'user_id' => $user->id,
                'shift_id' => $user->shift_id,
                'work_date' => $today,
                'check_in' => now(),
            ]);
        } else {
            $attendance->check_in = now();
            $attendance->save();
        }

        // Tính toán status
        $attendance->calculateCheckInStatus();
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Check-in thành công!',
            'attendance' => $attendance,
        ]);
    }

    /**
     * Check-out (tự động khi đăng xuất)
     */
    public function checkOut($userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : Auth::user();
        
        // Kiểm tra xem có phải staff không
        if (!$user->hasRole('staff')) {
            return response()->json(['error' => 'Chỉ nhân viên mới được check-out'], 403);
        }

        $today = Carbon::today();
        
        // Tìm attendance hôm nay
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('work_date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chưa check-in hôm nay',
            ]);
        }

        if ($attendance->check_out) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã check-out hôm nay rồi',
            ]);
        }

        // Update check-out
        $attendance->check_out = now();
        $attendance->calculateCheckOutStatus();
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Check-out thành công!',
            'attendance' => $attendance,
        ]);
    }
}

