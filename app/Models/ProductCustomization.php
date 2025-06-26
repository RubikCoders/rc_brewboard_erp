<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(int[] $array)
 */
class ProductCustomization extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCustomizationFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'required'
    ];

    //region Relationships
    public function product()
    {
        return $this->belongsTo(MenuProduct::class, 'product_id');
    }

    public function options()
    {
        return $this->hasMany(CustomizationOption::class, 'customization_id');
    }

    public function orderProductCustomizations()
    {
        return $this->hasMany(OrderCustomization::class, 'product_customization_id');
    }

    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'stockable');
    }
    //endregion
}
