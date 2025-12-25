<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('settings.index', compact('user'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        // Placeholder for future settings updates
        // You can add notification preferences, language, theme, etc.
        
        return redirect()->route('settings.index')
            ->with('success', 'Cài đặt đã được cập nhật');
    }
}

