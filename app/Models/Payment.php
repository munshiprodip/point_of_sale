<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'payment_uid',
        'invoice_id',
        'amount',
        'status',
        'received_by',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, "received_by");
    }
}
