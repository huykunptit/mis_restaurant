<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('role');
        
        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.index')
                ->withErrors($validator)
                ->withInput();
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('profile.index')
                    ->with('error', 'Mật khẩu hiện tại không đúng');
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Cập nhật thông tin thành công');
    }
}

