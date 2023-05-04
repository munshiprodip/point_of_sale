<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_no',
        'patient_id',
        'anaemia',
        'jaundice',
        'cyanosis',
        'oedema',
        'dehydration',
        'pulse_rate',
        'sao2',
        'respiratory_rate',
        'bp_systolic',
        'bp_diastolic',
        'temperature',
        'height',
        'weight',
        'bmi',
        'rr',
        'ofc',
        'bsa',
        'us_ratio',
        'ls_ratio',
        'other_oe',
        'chief_complaints',
        'case_summary',
        'past_medical_history',
        'past_surgical_history',
        'past_personal_history',
        'past_family_history',
        'past_drug_history',
        'allergy_history',
        'food_allergy',
        'drug_allergy',
        'other_allergy',
        'cardiovascular_system',
        'respiratory_system',
        'abdominal_system',
        'genito_urinary_system',
        'locomotor_system',
        'nervous_system',
        'others_system',
        'investigations',
        'diagnosis',
        'procedure',
        'advice',
        'follow_up',
        'next_visit',
        'image',
        'status',
        'created_by',
        'on_examination'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, "patient_id");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
