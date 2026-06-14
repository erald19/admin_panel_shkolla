<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'studentCount' => User::where('role', 0)->count(),
            'teacherCount' => User::where('role', 2)->count(),
            'adminCount'   => User::where('role', 1)->count(),
            'recentUsers'  => User::latest()->take(8)->get(),
        ]);
    }
}
