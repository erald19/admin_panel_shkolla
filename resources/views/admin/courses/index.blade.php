@extends('layouts.admin')
@section('title', 'Courses')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:20px;font-weight:700">Courses</h2>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ Add Course</a>
</div>

<div class="card" style="padding:0;overflow:hidden">
    <table>
        <thead><tr><th>Name</th><th>Teacher</th><th>Room</th><th>Description</th><th></th></tr></thead>
        <tbody>
        @forelse($courses as $c)
            <tr>
                <td><strong>{{ $c->name }}</strong></td>
                <td style="color:#64748b">{{ $c->teacher ?? '—' }}</td>
                <td style="color:#64748b">{{ $c->room ?? '—' }}</td>
                <td style="color:#94a3b8;font-size:13px">{{ Str::limit($c->description, 50) ?? '—' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.courses.destroy', $c) }}" onsubmit="return confirm('Delete this course?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:28px">No courses yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
