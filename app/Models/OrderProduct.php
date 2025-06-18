<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /** @use HasFactory<\Database\Factories\OrderProductFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'is_delivered',
        'total_price',
        'notes',
        'kitchen_status',
    ];

    //region Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(MenuProduct::class, 'product_id');
    }

    public function customizations()
    {
        return $this->hasMany(OrderProductCustomization::class, 'order_product_id');
    }
    //endregion
}
