@extends('layouts.admin')
@section('title', 'Admins')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <div>
        <h2 style="font-size:20px;font-weight:700;color:#1e293b">Admins</h2>
        <p style="font-size:13px;color:#94a3b8;margin-top:3px">{{ $users->total() }} admin accounts</p>
    </div>
    <button class="btn btn-primary" onclick="openModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Add Admin
    </button>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>Administrator</th>
                <th>Joined</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            @php
                $initials = strtoupper(substr($u->name,0,1).substr($u->surname??'',0,1));
                $colors   = ['#d97706','#b45309','#92400e','#c2410c','#dc2626'];
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
                <td style="color:#94a3b8;font-size:13px">{{ $u->created_at->format('d M Y') }}</td>
                <td style="width:52px">
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete admin {{ $u->name }}?')">
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
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <p>No other admins. Click <strong>Add Admin</strong> to create one.</p>
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
    @include('admin.users._add_modal', ['defaultRole' => 1, 'roleLabel' => 'Admin'])
@endpush
