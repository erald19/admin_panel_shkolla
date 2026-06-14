<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'day_of_week', 'start_time', 'end_time', 'room'];

    protected $appends = ['day_name'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getDayNameAttribute(): string
    {
        return ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'][$this->day_of_week] ?? '';
    }
}
