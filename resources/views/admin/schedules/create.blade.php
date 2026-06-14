@extends('layouts.admin')
@section('title', 'Add Schedule Entry')

@section('content')
<div style="max-width:480px">
    <h2 style="font-size:20px;font-weight:700;margin-bottom:20px">Add Schedule Entry</h2>

    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('admin.schedules.store') }}">
            @csrf
            <div class="form-group">
                <label>Course</label>
                <select class="form-control" name="course_id" required>
                    <option value="">Select course…</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Day of Week</label>
                <select class="form-control" name="day_of_week" required>
                    <option value="">Select day…</option>
                    @foreach([1=>'Monday',2=>'Tuesday',3=>'Wednesday',4=>'Thursday',5=>'Friday'] as $num => $day)
                        <option value="{{ $num }}" {{ old('day_of_week') == $num ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Start Time</label>
                    <input class="form-control" type="time" name="start_time" value="{{ old('start_time') }}" required>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <input class="form-control" type="time" name="end_time" value="{{ old('end_time') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Room (optional override)</label>
                <input class="form-control" name="room" value="{{ old('room') }}">
            </div>
            <div style="display:flex;gap:10px;margin-top:4px">
                <button type="submit" class="btn btn-primary">Save Entry</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn" style="background:#f1f5f9;color:#64748b">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
