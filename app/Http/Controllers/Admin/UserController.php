<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function students()
    {
        $users = User::where('role', 0)->latest()->paginate(20);
        return view('admin.users.students', compact('users'));
    }

    public function teachers()
    {
        $users = User::where('role', 2)->latest()->paginate(20);
        return view('admin.users.teachers', compact('users'));
    }

    public function admins()
    {
        $users = User::where('role', 1)->where('id', '!=', auth()->id())->latest()->paginate(20);
        return view('admin.users.admins', compact('users'));
    }

    public function store(Request $request)
    {
        $role = (int) $request->input('role');

        $rules = [
            'name'     => 'required|string|max:100',
            'surname'  => 'nullable|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|integer|in:0,1,2',
        ];

        if ($role === 0) {
            $rules['age']         = 'nullable|integer|min:1|max:99';
            $rules['numri_amzes'] = 'nullable|string|max:100';
            $rules['grade']       = 'nullable|string|max:20';
        }

        if ($role === 2) {
            $rules['age'] = 'nullable|integer|min:1|max:99';
        }

        $data             = $request->validate($rules);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        $redirect = match ($role) {
            0       => 'admin.users.students',
            2       => 'admin.users.teachers',
            default => 'admin.users.admins',
        };

        return redirect()->route($redirect)->with('success', 'User created successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
