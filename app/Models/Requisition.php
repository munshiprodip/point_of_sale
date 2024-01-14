<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'requisition_uid',
        'shop_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function requisition_items()
    {
        return $this->hasMany(RequisitionItem::class);
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
