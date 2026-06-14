@extends('layouts.admin')
@section('title', 'Students')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:20px;font-weight:700">Students</h2>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Add Student</a>
</div>

<div class="card" style="padding:0;overflow:hidden">
    <table>
        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Joined</th><th></th></tr></thead>
        <tbody>
        @forelse($students as $s)
            <tr>
                <td><strong>{{ $s->name }} {{ $s->surname }}</strong></td>
                <td style="color:#64748b">{{ $s->email }}</td>
                <td style="color:#64748b">{{ $s->phone ?? '—' }}</td>
                <td style="color:#94a3b8;font-size:12px">{{ $s->created_at->format('d M Y') }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.students.destroy', $s) }}" onsubmit="return confirm('Delete this student?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:28px">No students yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div>{{ $students->links() }}</div>
@endsection
