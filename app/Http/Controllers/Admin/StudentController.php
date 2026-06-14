<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role', 0)->latest()->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'surname'  => 'nullable|string|max:100',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:30',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $data['name'],
            'surname'  => $data['surname'] ?? null,
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role'     => 0,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student added successfully.');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return back()->with('success', 'Student deleted.');
    }
}
