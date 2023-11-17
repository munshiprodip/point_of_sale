<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'date',
        'in_time',
        'out_time',
        'schedule_in',
        'schedule_out',
        'lunch_out',
        'lunch_in',
        'is_present',
        'is_day_off',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, "employee_id");
    }
}
