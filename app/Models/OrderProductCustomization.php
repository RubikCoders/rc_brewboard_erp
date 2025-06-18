<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductCustomization extends Model
{
    /** @use HasFactory<\Database\Factories\OrderProductCustomizationFactory> */
    use HasFactory;

    protected $fillable = [
        'order_product_id',
        'product_customization_id'
    ];

    //region Relationships
    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    public function customization()
    {
        return $this->belongsTo(ProductCustomization::class, 'product_customization_id');
    }
    //endregion
}
