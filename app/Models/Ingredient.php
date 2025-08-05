<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ingredient extends Model
{
    use HasFactory;

    //region Attributes
    protected $fillable = [
        'name',
        'unit',
        'category',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    //endregion

    //region Relationships
    /**
     * Relación polimórfica con inventario
     */
    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'stockable');
    }

    /**
     * Productos que usan este ingrediente (relación polimórfica inversa)
     */
    public function productIngredients()
    {
        return $this->morphMany(ProductIngredient::class, 'ingredient');
    }

    /**
     * Productos del menú que requieren este ingrediente
     */
    public function menuProducts()
    {
        return $this->morphedByMany(
            MenuProduct::class,
            'ingredient',
            'product_ingredients',
            'ingredient_id',
            'menu_product_id'
        )->withPivot(['quantity_needed', 'unit', 'notes']);
    }
    //endregion

    //region Scopes
    /**
     * Scope para ingredientes activos
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope por categoría
     */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Scope para ingredientes con stock bajo
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereHas('inventory', function (Builder $query) {
            $query->whereRaw('stock <= min_stock');
        });
    }

    /**
     * Scope para ingredientes sin stock
     */
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->whereHas('inventory', function (Builder $query) {
            $query->where('stock', '<=', 0);
        });
    }
    //endregion

    //region Methods
    /**
     * Verifica si el ingrediente tiene stock suficiente
     */
    public function hasStock(float $quantityNeeded = 1): bool
    {
        if (!$this->inventory) {
            return false;
        }

        return $this->inventory->stock >= $quantityNeeded;
    }

    /**
     * Obtiene el stock actual
     */
    public function getCurrentStock(): int
    {
        return $this->inventory?->stock ?? 0;
    }

    /**
     * Verifica si está en stock bajo
     */
    public function isLowStock(): bool
    {
        if (!$this->inventory) {
            return true;
        }

        return $this->inventory->stock <= $this->inventory->min_stock;
    }

    /**
     * Verifica si está agotado
     */
    public function isOutOfStock(): bool
    {
        return $this->getCurrentStock() <= 0;
    }

    /**
     * Obtiene el estado del stock
     */
    public function getStockStatus(): string
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        }

        if ($this->isLowStock()) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    /**
     * Consume stock del ingrediente
     */
    public function consumeStock(float $quantity): bool
    {
        if (!$this->hasStock($quantity)) {
            return false;
        }

        $this->inventory->decrement('stock', $quantity);
        return true;
    }

    /**
     * Agrega stock al ingrediente
     */
    public function addStock(float $quantity): void
    {
        if ($this->inventory) {
            $this->inventory->increment('stock', $quantity);
        }
    }
    //endregion
}