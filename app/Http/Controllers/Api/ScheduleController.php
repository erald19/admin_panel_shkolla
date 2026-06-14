<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with('course');

        if ($request->has('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->has('day')) {
            $query->where('day_of_week', $request->day);
        }

        return response()->json(
            $query->orderBy('day_of_week')->orderBy('start_time')->get()
        );
    }
}
