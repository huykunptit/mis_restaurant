<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('guest.login');
    }

    public function login(Request $request, User $users)
    {   
        
        $this->validate($request, [
            'email' => 'required|email|max:200',
            'password' => 'required|string|max:200',
        ]);

        $remember = $request->filled('remember');

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = auth()->user();
            
            if ($user->hasRole('admin')) {
                return redirect()->route('home.admin');
            } elseif ($user->hasRole('staff')) {
                return redirect()->route('home.staff');
            } elseif ($user->hasRole('customer')) {
                return redirect()->route('home.customer');
            }
        }

        return redirect()
            ->route('login')
            ->withInput()
            ->with('error', 'Invalid email or password. Please try again.');
    }

}
