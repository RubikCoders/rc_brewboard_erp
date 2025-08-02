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
    public function getImageUrlAttribute(): ?string
    {
        // Array de extensiones de imagen soportadas
        $supportedExtensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];

        if ($this->attributes['image_url'] && str_contains($this->attributes['image_url'], '/storage/products/')) {
            $filename = basename($this->attributes['image_url']);
            $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);

            // Buscar archivo con cualquier extensión soportada
            foreach ($supportedExtensions as $ext) {
                $testFilename = $nameWithoutExt . '.' . $ext;
                $fullPath = storage_path('app/public/products/' . $testFilename);

                if (file_exists($fullPath)) {
                    return asset('storage/products/' . $testFilename);
                }
            }
        }

        if ($this->image_path) {
            // Si es ruta relativa (FileUpload nuevo)
            if (!str_starts_with($this->image_path, '/')) {
                $fullPath = storage_path('app/public/' . $this->image_path);

                if (file_exists($fullPath)) {
                    return asset('storage/' . $this->image_path);
                }
            } else {
                // Si es ruta absoluta (seeder), extraer filename y buscar con diferentes extensiones
                $originalFilename = basename($this->image_path);
                $nameWithoutExt = pathinfo($originalFilename, PATHINFO_FILENAME);

                // Buscar archivo con cualquier extensión soportada
                foreach ($supportedExtensions as $ext) {
                    $testFilename = $nameWithoutExt . '.' . $ext;
                    $fullPath = storage_path('app/public/products/' . $testFilename);

                    if (file_exists($fullPath)) {
                        return asset('storage/products/' . $testFilename);
                    }
                }
            }
        }

        if ($this->name) {
            $productSlug = \Illuminate\Support\Str::slug($this->name);

            foreach ($supportedExtensions as $ext) {
                $testFilename = $productSlug . '.' . $ext;
                $fullPath = storage_path('app/public/products/' . $testFilename);

                if (file_exists($fullPath)) {
                    return asset('storage/products/' . $testFilename);
                }
            }
        }

        if ($this->id) {
            foreach ($supportedExtensions as $ext) {
                $testFilename = 'product_' . $this->id . '.' . $ext;
                $fullPath = storage_path('app/public/products/' . $testFilename);

                if (file_exists($fullPath)) {
                    return asset('storage/products/' . $testFilename);
                }
            }
        }
        
        return null;
    }

    public function hasValidImage(): bool
    {
        return !is_null($this->getImageUrlAttribute());
    }

    public function getImageOrDefault(?string $defaultUrl = null): string
    {
        $imageUrl = $this->getImageUrlAttribute();

        if ($imageUrl) {
            return $imageUrl;
        }

        return $defaultUrl ?? asset('images/placeholder-product.jpg');
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
