@extends('layouts.admin')
@section('title', 'Schedule')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:20px;font-weight:700">Weekly Schedule</h2>
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">+ Add Entry</a>
</div>

<div class="card" style="padding:0;overflow:hidden">
    <table>
        <thead><tr><th>Day</th><th>Course</th><th>Teacher</th><th>Time</th><th>Room</th><th></th></tr></thead>
        <tbody>
        @forelse($schedules as $s)
            <tr>
                <td><strong>{{ $s->day_name }}</strong></td>
                <td>{{ $s->course->name }}</td>
                <td style="color:#64748b">{{ $s->course->teacher ?? '—' }}</td>
                <td style="color:#64748b">{{ substr($s->start_time,0,5) }} – {{ substr($s->end_time,0,5) }}</td>
                <td style="color:#64748b">{{ $s->room ?? $s->course->room ?? '—' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.schedules.destroy', $s) }}" onsubmit="return confirm('Delete this entry?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:28px">No schedule entries yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
