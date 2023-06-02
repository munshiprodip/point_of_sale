<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'organization_id',
        'start_time',
        'end_time',
        'saturday',
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'status',
        'created_by',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, "organization_id");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
