<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(string[] $array)
 */
class MenuCategory extends Model
{
    /** @use HasFactory<\Database\Factories\MenuCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        // Prevenir eliminación si tiene productos
        static::deleting(function ($category) {
            if ($category->products()->count() > 0) {
                throw new \Exception(__('category.notifications.cannot_delete_with_products'));
            }
        });

        // Normalizar datos antes de guardar
        static::saving(function ($category) {
            $category->name = ucwords(strtolower(trim($category->name)));
            if (empty(trim($category->description))) {
                $category->description = null;
            }
        });
    }

    public function scopeWithProductsCount($query)
    {
        return $query->withCount('products');
    }

    public function scopePopulated($query)
    {
        return $query->has('products');
    }

    public function scopeEmpty($query)
    {
        return $query->doesntHave('products');
    }

    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    public function getStatusAttribute()
    {
        return $this->products_count > 0 ? 'populated' : 'empty';
    }

    public function getStatusLabelAttribute()
    {
        return $this->status === 'populated'
            ? __('category.states.populated')
            : __('category.states.empty');
    }

    public function getProductsUrlAttribute()
    {
        return route('filament.admin.resources.menu.menu-products.index', [
            'tableFilters' => ['category_id' => ['value' => $this->id]]
        ]);
    }

    public static function getValidationRules($ignoreId = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:menu_categories,name' . ($ignoreId ? ",{$ignoreId}" : ''),
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public static function getMostPopular($limit = 5)
    {
        return static::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public static function getStats(): array
    {
        return [
            'total' => static::count(),
            'with_products' => static::has('products')->count(),
            'empty' => static::doesntHave('products')->count(),
            'avg_products' => round(static::withCount('products')->avg('products_count') ?? 0, 1),
        ];
    }

    //region Relationships
    public function products()
    {
        return $this->hasMany(MenuProduct::class, 'category_id');
    }
    //endregion
}
