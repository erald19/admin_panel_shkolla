<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('course')->orderBy('day_of_week')->orderBy('start_time')->get();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.schedules.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'day_of_week' => 'required|integer|between:1,5',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'room'        => 'nullable|string|max:50',
        ]);

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('success', 'Schedule entry added.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Schedule entry deleted.');
    }
}
