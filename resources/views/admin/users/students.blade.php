@extends('layouts.admin')
@section('title', 'Students')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <div>
        <h2 style="font-size:20px;font-weight:700;color:#1e293b">Students</h2>
        <p style="font-size:13px;color:#94a3b8;margin-top:3px">{{ $users->total() }} registered students</p>
    </div>
    <button class="btn btn-primary" onclick="openModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Add Student
    </button>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Grade</th>
                <th>Numri Amzës</th>
                <th>Age</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            @php
                $initials = strtoupper(substr($u->name,0,1).substr($u->surname??'',0,1));
                $colors   = ['#4f46e5','#0891b2','#7c3aed','#0369a1','#059669'];
                $color    = $colors[$u->id % count($colors)];
            @endphp
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="u-avatar" style="background:{{ $color }}">{{ $initials }}</div>
                        <div>
                            <div class="u-name">{{ $u->name }} {{ $u->surname }}</div>
                            <div class="u-email">{{ $u->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($u->grade)
                        <span style="display:inline-block;background:#eef2ff;color:#4f46e5;font-size:12px;font-weight:700;padding:3px 10px;border-radius:20px">{{ $u->grade }}</span>
                    @else
                        <span style="color:#cbd5e1">—</span>
                    @endif
                </td>
                <td style="color:#64748b;font-size:13px">{{ $u->numri_amzes ?? '—' }}</td>
                <td style="color:#64748b">
                    {{ $u->age ? $u->age.' yrs' : '—' }}
                </td>
                <td style="width:52px">
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn-icon" type="submit" title="Delete">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">
                <div class="table-empty">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <p>No students yet. Click <strong>Add Student</strong> to create one.</p>
                </div>
            </td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div style="margin-top:16px;display:flex;justify-content:flex-end">{{ $users->links() }}</div>
@endif
@endsection

@push('modals')
    @include('admin.users._add_modal', ['defaultRole' => 0, 'roleLabel' => 'Student'])
@endpush
