<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteMedication extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'medicine',
        'dose',
        'instruction',
        'duration',
        'note',
        'created_by',
    ];
}
