<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_uid',
        'shop_id',
        'subtotal',
        'discount',
        'transport_cost',
        'total',
        'status',
        'created_by',
        'updated_by',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function purchase_items()
    {
        return $this->hasMany(PurchaseItem::class);
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
