<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employment_id',
        'organization_id',
        'department_id',
        'designation',
        'optional',
        'schedule_id',
        'mobile',
        'joining_date',
        'status',
        'created_by',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function department()
    {
        return $this->belongsTo(Department::class, "department_id");
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, "schedule_id");
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
