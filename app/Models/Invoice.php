<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_uid',
        'shop_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'sub_total',
        'discount',
        'vat',
        'total',
        'paid_amount',
        'status',
        'created_by',
        'updated_by',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, "updated_by");
    }
}
