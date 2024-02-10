<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'name',
        'introduction',
        'start_time',
        'end_time',
    ];

    public function getTeacherIdAttribute()
    {
        return $this->attributes['user_id'];
    }

    public function setTeacherIdAttribute($value)
    {
        $this->attributes['user_id'] = $value;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $this->convertTimeFormat($value);
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $this->convertTimeFormat($value);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    private function convertTimeFormat($time)
    {
        return Carbon::createFromFormat('Hi', $time)->format('H:i:s');
    }
}
