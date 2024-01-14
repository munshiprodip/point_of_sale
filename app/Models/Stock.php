<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'product_id',
        'quantity',
        'updated_by',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, "updated_by");
    }
}
