<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'strength',
        'generic_id',
        'company_id',
        'status',
        'created_by',
    ];

    public function company()
    {
       return $this->belongsTo(Company::class, "company_id");
    }

    public function generic()
    {
        return $this->belongsTo(Generic::class, "generic_id");
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
}
