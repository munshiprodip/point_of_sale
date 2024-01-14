<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashDeposite extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'amount',
        'status',
        'created_by',
        'received_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
   
    public function receivedBy()
    {
        return $this->belongsTo(User::class, "received_by");
    }
}
