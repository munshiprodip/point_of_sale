<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'created_by',
    ];

    public function templated_medicine()
    {
        return $this->hasMany(TemplatedMedicine::class);
    }
}
