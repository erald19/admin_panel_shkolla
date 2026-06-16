@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <div>
        <h2 style="font-size:20px;font-weight:700;color:#1e293b">Users</h2>
        <p style="font-size:13px;color:#94a3b8;margin-top:3px">{{ $users->total() }} total members</p>
    </div>
    <button class="btn btn-primary" onclick="openModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
        Add User
    </button>
</div>

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Role</th>
                <th>Grade</th>
                <th>Numri Amzës</th>
                <th>Age</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            @php
                $initials = strtoupper(substr($u->name, 0, 1) . substr($u->surname ?? '', 0, 1));
                $colors   = ['#4f46e5','#0891b2','#059669','#d97706','#dc2626','#7c3aed','#0369a1'];
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
                    @if($u->role === 0)
                        <span class="role-badge role-0">Student</span>
                    @elseif($u->role === 1)
                        <span class="role-badge role-1">Admin</span>
                    @else
                        <span class="role-badge role-2">Teacher</span>
                    @endif
                </td>
                <td>
                    @if($u->grade)
                        <span style="font-weight:600;color:#1e293b">{{ $u->grade }}</span>
                    @else
                        <span style="color:#cbd5e1">—</span>
                    @endif
                </td>
                <td style="color:#64748b;font-size:13px">{{ $u->numri_amzes ?? '—' }}</td>
                <td style="color:#64748b">
                    @if($u->age)
                        <span style="font-weight:500">{{ $u->age }}</span>
                    @else
                        <span style="color:#cbd5e1">—</span>
                    @endif
                </td>
                <td style="width:52px">
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn-icon" type="submit" title="Delete user">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <div class="table-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <p>No users yet. Click <strong>Add User</strong> to create one.</p>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
    <div style="margin-top:16px;display:flex;justify-content:flex-end">
        {{ $users->links() }}
    </div>
@endif

@endsection

@push('modals')
<!-- ── Add User Modal ── -->
<div class="modal-overlay" id="userModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">×</button>

        <!-- Step 1: Role picker -->
        <div id="step1">
            <h2>Add User</h2>
            <p class="modal-sub">Select the role for the new user</p>
            <div class="role-picker">
                <div class="role-card" onclick="selectRole(0, this)">
                    <svg fill="none" stroke="#4f46e5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <div class="rc-label">Student</div>
                    <div class="rc-sub">Nxënës</div>
                </div>
                <div class="role-card" onclick="selectRole(2, this)">
                    <svg fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <div class="rc-label">Teacher</div>
                    <div class="rc-sub">Mësues</div>
                </div>
                <div class="role-card" onclick="selectRole(1, this)">
                    <svg fill="none" stroke="#d97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <div class="rc-label">Admin</div>
                    <div class="rc-sub">Administrator</div>
                </div>
            </div>
        </div>

        <!-- Step 2: Form -->
        <form method="POST" action="{{ route('admin.users.store') }}" id="userForm" style="display:none;margin-top:24px">
            @csrf
            <input type="hidden" name="role" id="roleInput">

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px">
                <button type="button" onclick="backToStep1()" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:13px;padding:0;font-family:inherit;">← Back</button>
                <h2 id="formTitle" style="font-size:16px;font-weight:700;margin:0"></h2>
            </div>

            @if($errors->any())
                <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label>First Name *</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Surname</label>
                    <input class="form-control" name="surname" value="{{ old('surname') }}">
                </div>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password *</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <!-- Student-only fields -->
            <div class="form-section" id="studentFields">
                <div class="form-row">
                    <div class="form-group">
                        <label>Age</label>
                        <input class="form-control" type="number" name="age" value="{{ old('age') }}" min="1" max="99">
                    </div>
                    <div class="form-group">
                        <label>Grade</label>
                        <input class="form-control" name="grade" value="{{ old('grade') }}" placeholder="e.g. 9A">
                    </div>
                </div>
                <div class="form-group">
                    <label>Numri Amzës</label>
                    <input class="form-control" name="numri_amzes" value="{{ old('numri_amzes') }}">
                </div>
            </div>

            <!-- Teacher-only fields -->
            <div class="form-section" id="teacherFields">
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" type="number" name="age" value="{{ old('age') }}" min="1" max="99">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create User</button>
                <button type="button" class="btn" style="background:#f1f5f9;color:#64748b" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentRole = null;

    function openModal() {
        document.getElementById('userModal').classList.add('open');
        @if($errors->any() && old('role') !== null)
            selectRole({{ old('role', 0) }}, null);
        @endif
    }

    function closeModal() {
        document.getElementById('userModal').classList.remove('open');
    }

    function selectRole(role, card) {
        currentRole = role;
        document.getElementById('roleInput').value = role;
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        if (card) card.classList.add('selected');
        const titles = { 0: 'New Student', 1: 'New Admin', 2: 'New Teacher' };
        document.getElementById('formTitle').textContent = titles[role];
        document.getElementById('studentFields').classList.toggle('visible', role === 0);
        document.getElementById('teacherFields').classList.toggle('visible', role === 2);
        document.getElementById('step1').style.display = 'none';
        document.getElementById('userForm').style.display = 'block';
    }

    function backToStep1() {
        document.getElementById('step1').style.display = 'block';
        document.getElementById('userForm').style.display = 'none';
    }

    document.getElementById('userModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    @if($errors->any())
        openModal();
    @endif
</script>
@endpush
