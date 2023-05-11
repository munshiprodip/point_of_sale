<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'nid',
        'phone',
        'dob',
        'reg_no',
        'avater',
        'signature',
        'gender',
        'religion',
        'nationality',
        'bloodgroup',
        'present_address',
        'permanent_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function settings()
    {
        return $this->hasMany(PersonalSetting::class, 'created_by');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'created_by');
    }

    public function clinicalComponents()
    {
        return $this->belongsToMany(ClinicalComponent::class, 'user_clinical_component', 'user_id', 'clinical_component_id');
    }

    public function favourites($component_type) // $type = (case_summery, chief_complaint, on_examination, diagnosis, investigation, reocedure)
    {
        if($component_type == 'all'){
            return $this->belongsToMany(ClinicalComponent::class);
        }
        return $this->belongsToMany(ClinicalComponent::class, 'user_clinical_component', 'user_id', 'clinical_component_id')->where('component_type', $component_type);
    }
}
