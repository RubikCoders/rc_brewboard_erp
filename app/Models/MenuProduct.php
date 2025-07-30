<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    //region Mutators
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): ?string {                
                if ($value && str_contains($value, '/storage/products/')) {
                    return $value;
                }
                
                if (!$value && $this->image_path) {                    
                    if (!str_starts_with($this->image_path, '/')) {
                        return asset('storage/' . $this->image_path);
                    }
            
                    $filename = basename($this->image_path);
                    return asset('storage/products/' . $filename);
                }

                if ($value) {
                    return asset($value);
                }
                
                return null;
            }
        );
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
