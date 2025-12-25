<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Tự động check-out cho nhân viên
        if ($user && $user->hasRole('staff')) {
            $attendanceController = new \App\Http\Controllers\AttendanceController();
            $attendanceController->checkOut($user->id);
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
