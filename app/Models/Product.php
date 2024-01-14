<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'sku',
        'purchase_price',
        'sale_price',
        'uom',
        'status',
        'created_by',
        'updated_by',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stockQty($shop_id)
    {
        $stock =  $this->stocks()->where('shop_id', $shop_id)->first();
        return $stock ? $stock->quantity : 0;
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
