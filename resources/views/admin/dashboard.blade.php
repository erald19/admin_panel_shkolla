@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card">
        <div class="label">Students</div>
        <div class="value" style="color:#4f46e5">{{ $studentCount }}</div>
        <div class="sub">Registered students</div>
    </div>
    <div class="stat-card">
        <div class="label">Teachers</div>
        <div class="value" style="color:#059669">{{ $teacherCount }}</div>
        <div class="sub">Active teachers</div>
    </div>
    <div class="stat-card">
        <div class="label">Admins</div>
        <div class="value" style="color:#d97706">{{ $adminCount }}</div>
        <div class="sub">Admin users</div>
    </div>
    <div class="stat-card">
        <div class="label">Total Users</div>
        <div class="value" style="color:#0891b2">{{ $studentCount + $teacherCount + $adminCount }}</div>
        <div class="sub">All accounts</div>
    </div>
</div>

<div class="card">
    <div class="card-title">Recent Users</div>
    @if($recentUsers->isEmpty())
        <p style="color:#94a3b8;font-size:14px">No users yet. <a href="{{ route('admin.users.index') }}" style="color:#4f46e5">Add one.</a></p>
    @else
        <table>
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Grade</th><th>Joined</th></tr></thead>
            <tbody>
            @foreach($recentUsers as $u)
                <tr>
                    <td><strong>{{ $u->name }} {{ $u->surname }}</strong></td>
                    <td style="color:#64748b">{{ $u->email }}</td>
                    <td>
                        @if($u->role === 0)
                            <span class="role-badge role-0">Student</span>
                        @elseif($u->role === 1)
                            <span class="role-badge role-1">Admin</span>
                        @else
                            <span class="role-badge role-2">Teacher</span>
                        @endif
                    </td>
                    <td style="color:#64748b">{{ $u->grade ?? '—' }}</td>
                    <td style="color:#94a3b8;font-size:12px">{{ $u->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
