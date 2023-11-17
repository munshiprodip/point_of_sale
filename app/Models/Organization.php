<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'flex_time',
        'logo',
        'founder',
        'address',
        'is_track_lunch',
        'chat_id',
        'notification_status',
        'created_by',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
