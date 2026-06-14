@extends('layouts.admin')
@section('title', 'Add Student')

@section('content')
<div style="max-width:560px">
    <h2 style="font-size:20px;font-weight:700;margin-bottom:20px">Add Student</h2>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Surname</label>
                    <input class="form-control" name="surname" value="{{ old('surname') }}">
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input class="form-control" name="phone" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <div style="display:flex;gap:10px;margin-top:4px">
                <button type="submit" class="btn btn-primary">Save Student</button>
                <a href="{{ route('admin.students.index') }}" class="btn" style="background:#f1f5f9;color:#64748b">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
