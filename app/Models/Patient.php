<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'registration_no',
        'nid',
        'dob',
        'name',
        'father_name',
        'mother_name',
        'marital_status',
        'spouse_name',
        'gender',
        'religion',
        'nationality',
        'phone',
        'email',
        'occupation',
        'bloodgroup',
        'present_address',
        'permanent_address',
        'status',
        'created_by',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, "patient_id");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }

}
