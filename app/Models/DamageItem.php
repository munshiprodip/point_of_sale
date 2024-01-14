<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'product_id',
        'quantity',
        'comment',
        'status',
        'created_by',
        'verified_by',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, "verified_by");
    }
}
