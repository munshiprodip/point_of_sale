<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'product_id',
        'unit_price',
        'quantity',
        'total_price',
        'status',
        'created_by',
        'updated_by',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
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
