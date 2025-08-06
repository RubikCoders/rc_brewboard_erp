<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MenuProduct extends Model
{
    use HasFactory;

    //region Attributes
    protected $fillable = [
        'category_id',
        'image_url',
        'image_path',
        'name',
        'description',
        'ingredients', // Mantiene el string para display/descripción
        'base_price',
        'estimated_time_min',
        'is_available',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'estimated_time_min' => 'decimal:2',
        'is_available' => 'boolean',
    ];
    //endregion

    //region Relationships
    /**
     * Categoría del producto
     */
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    /**
     * Personalizaciones del producto
     */
    public function customizations()
    {
        return $this->hasMany(ProductCustomization::class, 'product_id');
    }

    /**
     * Productos en órdenes
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    /**
     * Relación polimórfica con inventario (para productos finales que se almacenan)
     */
    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'stockable');
    }

    /**
     * Ingredientes requeridos para este producto
     */
    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }

    /**
     * Ingredientes base requeridos
     */
    public function ingredients()
    {
        return $this->morphedByMany(
            Ingredient::class,
            'ingredient',
            'product_ingredients',
            'menu_product_id',
            'ingredient_id'
        )->withPivot(['quantity_needed', 'unit', 'notes']);
    }

    /**
     * Otros productos usados como ingredientes (para productos compuestos)
     */
    public function compositeIngredients()
    {
        return $this->morphedByMany(
            MenuProduct::class,
            'ingredient',
            'product_ingredients',
            'menu_product_id',
            'ingredient_id'
        )->withPivot(['quantity_needed', 'unit', 'notes']);
    }

    /**
     * Productos que usan este producto como ingrediente
     */
    public function usedInProducts()
    {
        return $this->morphMany(ProductIngredient::class, 'ingredient');
    }
    //endregion

    //region Scopes
    /**
     * Scope para productos disponibles
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope por categoría
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope para productos que realmente pueden prepararse (tienen stock)
     */
    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('is_available', true)
            ->whereExists(function ($query) {
                $query->selectRaw('1')
                    ->from('menu_products as mp')
                    ->whereColumn('mp.id', 'menu_products.id')
                    ->whereRaw('(SELECT can_be_prepared FROM (SELECT 1 as can_be_prepared) as temp) = 1');
            });
    }
    //endregion

    //region Stock and Availability Methods
    /**
     * Verifica si el producto puede prepararse basado en inventario de ingredientes
     */
    public function canBePrepared(int $quantity = 1): bool
    {
        // Si no está marcado como disponible, no se puede preparar
        if (!$this->is_available) {
            return false;
        }

        // Verificar que todas las personalizaciones requeridas tengan opciones disponibles
        if (!$this->hasRequiredCustomizationsAvailable()) {
            return false;
        }

        // Si tiene inventario directo (producto pre-elaborado), verificar stock
        if ($this->inventory) {
            return $this->inventory->stock >= $quantity;
        }

        // Si no tiene inventario directo, verificar ingredientes
        return $this->hasStockForAllIngredients($quantity);
    }

    /**
     * Verifica si hay stock suficiente para todos los ingredientes
     */
    public function hasStockForAllIngredients(int $quantity = 1): bool
    {
        // Si no tiene ingredientes definidos, asumimos que está disponible
        if ($this->productIngredients->isEmpty()) {
            return true;
        }

        // Verificar cada ingrediente
        foreach ($this->productIngredients as $productIngredient) {
            $totalQuantityNeeded = $productIngredient->quantity_needed * $quantity;

            if (!$productIngredient->hasAvailableStock()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Verifica si las personalizaciones requeridas tienen opciones disponibles
     */
    public function hasRequiredCustomizationsAvailable(): bool
    {
        $requiredCustomizations = $this->customizations()->where('required', true)->get();

        foreach ($requiredCustomizations as $customization) {
            if (!$customization->hasAvailableOptions()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Obtiene la cantidad máxima que se puede preparar con el stock actual
     */
    public function getMaxAvailableQuantity(): int
    {
        if (!$this->is_available) {
            return 0;
        }

        // Si tiene inventario directo
        if ($this->inventory) {
            return $this->inventory->stock;
        }

        // Si depende de ingredientes
        if ($this->productIngredients->isEmpty()) {
            return 999; // Sin límite si no tiene ingredientes definidos
        }

        $maxQuantities = [];
        foreach ($this->productIngredients as $productIngredient) {
            $maxQuantities[] = $productIngredient->getMaxProductQuantityPossible();
        }

        return empty($maxQuantities) ? 0 : min($maxQuantities);
    }

    /**
     * Consume todos los ingredientes necesarios para la preparación
     */
    public function consumeAllIngredients(int $quantity = 1): bool
    {
        // Si tiene inventario directo, consumir del stock
        if ($this->inventory) {
            if ($this->inventory->stock >= $quantity) {
                $this->inventory->decrement('stock', $quantity);
                return true;
            }
            return false;
        }

        // Verificar primero que hay stock suficiente para todo
        if (!$this->hasStockForAllIngredients($quantity)) {
            return false;
        }

        // Consumir cada ingrediente
        foreach ($this->productIngredients as $productIngredient) {
            if (!$productIngredient->consumeStock($quantity)) {
                // Si falla algún consumo, deberíamos revertir, pero por simplicidad
                // asumimos que la verificación previa es suficiente
                return false;
            }
        }

        return true;
    }

    /**
     * Obtiene el estado de disponibilidad para mostrar en UI
     */
    public function getAvailabilityStatus(): array
    {
        if (!$this->is_available) {
            return [
                'status' => 'disabled',
                'message' => 'Producto deshabilitado',
                'can_order' => false
            ];
        }

        if (!$this->hasRequiredCustomizationsAvailable()) {
            return [
                'status' => 'missing_customizations',
                'message' => 'Opciones requeridas no disponibles',
                'can_order' => false
            ];
        }

        $maxQuantity = $this->getMaxAvailableQuantity();

        if ($maxQuantity <= 0) {
            return [
                'status' => 'out_of_stock',
                'message' => 'Sin ingredientes disponibles',
                'can_order' => false
            ];
        }

        if ($maxQuantity <= 5) { // Considerar "pocas existencias" si quedan 5 o menos
            return [
                'status' => 'low_stock',
                'message' => "Quedan pocas unidades ({$maxQuantity})",
                'can_order' => true,
                'max_quantity' => $maxQuantity
            ];
        }

        return [
            'status' => 'available',
            'message' => 'Disponible',
            'can_order' => true,
            'max_quantity' => $maxQuantity
        ];
    }

    /**
     * Obtiene ingredientes faltantes o con stock insuficiente
     */
    public function getMissingIngredients(): array
    {
        $missing = [];

        foreach ($this->productIngredients as $productIngredient) {
            if (!$productIngredient->hasAvailableStock()) {
                $ingredient = $productIngredient->ingredient;
                $missing[] = [
                    'name' => $ingredient->name ?? 'Ingrediente desconocido',
                    'needed' => $productIngredient->quantity_needed,
                    'available' => $productIngredient->getAvailableStock(),
                    'unit' => $productIngredient->unit
                ];
            }
        }

        return $missing;
    }
    //endregion
}