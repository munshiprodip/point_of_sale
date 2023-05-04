<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplatedMedicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'medicine_template_id',
        'medicine',
        'dose',
        'instruction',
        'duration',
        'note',
    ];
}
