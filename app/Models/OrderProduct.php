<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class OrderProduct extends Model
{
    /** @use HasFactory<\Database\Factories\OrderProductFactory> */
    use HasFactory;

    public const KITCHEN_STATUS_IN_PROGRESS = 0;
    public const KITCHEN_STATUS_READY = 1;
    public const KITCHEN_STATUS_DELIVERED = 2;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'is_delivered',
        'total_price',
        'notes',
        'kitchen_status',
    ];

    //region Methods

    
    //endregion

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
        return $this->hasMany(OrderCustomization::class, 'order_product_id');
    }
    //endregion
}
