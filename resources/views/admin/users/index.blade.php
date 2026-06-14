@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:20px;font-weight:700">Users</h2>
    <button class="btn btn-primary" onclick="openModal()">+ Add User</button>
</div>

<div class="card" style="padding:0;overflow:hidden">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Grade</th>
                <th>Numri Amzës</th>
                <th>Age</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            <tr>
                <td>
                    <strong>{{ $u->name }} {{ $u->surname }}</strong>
                </td>
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
                <td style="color:#64748b">{{ $u->numri_amzes ?? '—' }}</td>
                <td style="color:#64748b">{{ $u->age ?? '—' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px">No users yet. Click "+ Add User" to create one.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div>{{ $users->links() }}</div>
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

        <!-- Step 2: Form (hidden until role selected) -->
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

            <!-- Common fields -->
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
        // If there were validation errors, re-open on the form step
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

        // Highlight selected card
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        if (card) card.classList.add('selected');

        // Set form title
        const titles = { 0: 'New Student', 1: 'New Admin', 2: 'New Teacher' };
        document.getElementById('formTitle').textContent = titles[role];

        // Show/hide role-specific fields
        document.getElementById('studentFields').classList.toggle('visible', role === 0);
        document.getElementById('teacherFields').classList.toggle('visible', role === 2);

        // Show form, hide step1
        document.getElementById('step1').style.display = 'none';
        document.getElementById('userForm').style.display = 'block';
    }

    function backToStep1() {
        document.getElementById('step1').style.display = 'block';
        document.getElementById('userForm').style.display = 'none';
    }

    // Close modal on overlay click
    document.getElementById('userModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // Auto-open modal if there were validation errors
    @if($errors->any())
        openModal();
    @endif
</script>
@endpush
