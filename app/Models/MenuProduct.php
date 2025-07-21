<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method static create(array $array)
 */
class MenuProduct extends Model
{
    /** @use HasFactory<\Database\Factories\MenuProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'image_url',
        'image_path',
        'name',
        'description',
        'ingredients',
        'base_price',
        'estimated_time_min',
        'is_available',
    ];

    //region Methods


    /**
     * Show available products with the base_price concatenated
     * @return mixed[]
     */
    public static function getAvailableGroupedByCategory()
    {
        return self::with('category')
            ->where('is_available', 1)
            ->get()
            ->groupBy(fn($product) => $product->category->name)
            ->map(function ($products) {
                return $products->mapWithKeys(function ($product) {
                    return [
                        $product->id => $product->name
                    ];
                });
            })
            ->toArray();
    }

    //endregion

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

    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'stockable');
    }
    //endregion
}
