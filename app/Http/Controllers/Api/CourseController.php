<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all(['id', 'name', 'teacher', 'room', 'description']));
    }

    public function show($id)
    {
        $course = Course::with('schedules')->findOrFail($id);
        return response()->json($course);
    }
}
