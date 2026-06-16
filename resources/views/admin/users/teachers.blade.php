@extends('layouts.admin')
@section('title', 'Teachers')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <div>
        <h2 style="font-size:20px;font-weight:700;color:#1e293b">Teachers</h2>
        <p style="font-size:13px;color:#94a3b8;margin-top:3px">{{ $users->total() }} active teachers</p>
    </div>
    <button class="btn btn-primary" onclick="openModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Add Teacher
    </button>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Age</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            @php
                $initials = strtoupper(substr($u->name,0,1).substr($u->surname??'',0,1));
                $colors   = ['#059669','#0f766e','#15803d','#047857','#065f46'];
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
                <td style="color:#64748b">{{ $u->age ? $u->age.' yrs' : '—' }}</td>
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
            <tr><td colspan="3">
                <div class="table-empty">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <p>No teachers yet. Click <strong>Add Teacher</strong> to create one.</p>
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
    @include('admin.users._add_modal', ['defaultRole' => 2, 'roleLabel' => 'Teacher'])
@endpush
