@extends('layouts.admin')
@section('title', 'Add Course')

@section('content')
<div style="max-width:560px">
    <h2 style="font-size:20px;font-weight:700;margin-bottom:20px">Add Course</h2>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            <div class="form-group">
                <label>Course Name</label>
                <input class="form-control" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Teacher</label>
                    <input class="form-control" name="teacher" value="{{ old('teacher') }}">
                </div>
                <div class="form-group">
                    <label>Room</label>
                    <input class="form-control" name="room" value="{{ old('room') }}">
                </div>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:4px">
                <button type="submit" class="btn btn-primary">Save Course</button>
                <a href="{{ route('admin.courses.index') }}" class="btn" style="background:#f1f5f9;color:#64748b">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
