<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        // Organization's info
        'org_title',
        'org_subtitle',
        'org_logo',
        'org_phone',
        'org_fax',
        'org_mail',
        'org_web',
        'org_address',

        // Prescribe page ui options
        'prescription_patient_info_modal',
        'prescription_vital_sign_modal',
        'prescription_allergy_modal',
        'prescription_past_history_modal',
        'prescription_gynae_obs_modal',
        'prescription_child_history_modal',

        'prescription_chief_complaint_tab',
        'prescription_case_summery_tab',
        'prescription_drug_history_tab',
        'prescription_on_examinition_tab',
        'prescription_investigation_tab',
        'prescription_diagnosis_tab',
        'prescription_procedure_tab',

        // Print settings options
        'print_margin_top',
        'print_margin_bottom',
        'print_margin_left',
        'print_margin_right',
        'print_chief_complaint',
        'print_case_summery',
        'print_on_examinition',
        'print_investigation',
        'print_diagnosis',
        'print_procedure',
        'print_advice',
        'print_follow_up',
        'print_signature',
        'print_image',
        'created_by'
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
