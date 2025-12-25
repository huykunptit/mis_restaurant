<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Lấy danh sách notifications
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Nếu là admin, lấy tất cả notifications (user_id = null hoặc admin id)
        if ($user->hasRole('admin')) {
            $notifications = Notification::whereNull('user_id')
                ->orWhere('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            $notifications = Notification::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return response()->json($notifications);
    }

    /**
     * Lấy số lượng notifications chưa đọc
     */
    public function unreadCount()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $count = Notification::whereNull('user_id')
                ->orWhere('user_id', $user->id)
                ->where('is_read', false)
                ->count();
        } else {
            $count = Notification::where('user_id', $user->id)
                ->where('is_read', false)
                ->count();
        }

        return response()->json(['count' => $count]);
    }

    /**
     * Đánh dấu notification là đã đọc
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Kiểm tra quyền
        if ($notification->user_id && $notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Đánh dấu tất cả notifications là đã đọc
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            Notification::whereNull('user_id')
                ->orWhere('user_id', $user->id)
                ->update(['is_read' => true]);
        } else {
            Notification::where('user_id', $user->id)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }
}

