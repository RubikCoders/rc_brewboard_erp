<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class MenuProduct extends Model
{
    /** @use HasFactory<\Database\Factories\MenuProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'ingredients',
        'base_price',
        'estimated_time_min',
        'is_available',
    ];

    //region Relationships
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function customizations()
    {
        return $this->hasMany(ProductCustomization::class, 'product_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
    //endregion
}
