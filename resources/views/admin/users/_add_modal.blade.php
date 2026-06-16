{{-- Variables: $defaultRole (int), $roleLabel (string) --}}
<div class="modal-overlay" id="userModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">×</button>

        <h2>Add {{ $roleLabel }}</h2>
        <p class="modal-sub">Fill in the details for the new {{ strtolower($roleLabel) }}</p>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <input type="hidden" name="role" value="{{ $defaultRole }}">

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

            @if($defaultRole === 0)
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
            @elseif($defaultRole === 2)
                <div class="form-group">
                    <label>Age</label>
                    <input class="form-control" type="number" name="age" value="{{ old('age') }}" min="1" max="99">
                </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create {{ $roleLabel }}</button>
                <button type="button" class="btn" style="background:#f1f5f9;color:#64748b" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('userModal').classList.add('open'); }
    function closeModal() { document.getElementById('userModal').classList.remove('open'); }
    document.getElementById('userModal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
    @if($errors->any()) openModal(); @endif
</script>
