<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::with(['role'])->paginate(10);

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {   
        $roles = Role::all();

        return view('user.create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required|string|max:200',
            'lastName' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email',
            'password' => 'required|string|min:6|max:200',
            'role' => 'required|exists:roles,id',
        ]);

        User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
        ]);

        return redirect()
            ->route('user.index')
            ->with('success', 'New user successfully added!');
    }

    public function edit($id)
    {   
        $user = User::findOrFail($id);
        $roles = Role::all();
        
        return view('user.edit', [
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'firstName' => 'required|string|max:200',
            'lastName' => 'required|string|max:200',
            'email' => 'required|email|max:200|unique:users,email,' . $id,
            'role' => 'required|exists:roles,id',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:6|max:200';
        }

        $this->validate($request, $rules);

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        } 

        $user->role_id = $request->role;
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success','User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success','User deleted successfully');
    }
}
