<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalComponent extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_bn',
        'component_type',
        'status',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");

    }
}
