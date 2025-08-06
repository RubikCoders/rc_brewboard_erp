<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    use HasFactory;

    //region Attributes
    protected $fillable = [
        'menu_product_id',
        'ingredient_type',
        'ingredient_id',
        'quantity_needed',
        'unit',
        'notes',
    ];

    protected $casts = [
        'quantity_needed' => 'decimal:2',
    ];
    //endregion

    //region Relationships
    /**
     * Producto del menú que requiere este ingrediente
     */
    public function menuProduct()
    {
        return $this->belongsTo(MenuProduct::class);
    }

    /**
     * Ingrediente requerido (relación polimórfica)
     * Puede ser Ingredient o MenuProduct
     */
    public function ingredient()
    {
        return $this->morphTo();
    }
    //endregion

    //region Methods
    /**
     * Verifica si hay stock suficiente para la cantidad requerida
     */
    public function hasAvailableStock(): bool
    {
        $ingredient = $this->ingredient;

        if (!$ingredient) {
            return false;
        }

        // Para Ingredient
        if ($ingredient instanceof Ingredient) {
            return $ingredient->hasStock($this->quantity_needed);
        }

        // Para MenuProduct (productos compuestos)
        if ($ingredient instanceof MenuProduct) {
            return $ingredient->hasStockForAllIngredients($this->quantity_needed);
        }

        return false;
    }

    /**
     * Consume el stock necesario
     */
    public function consumeStock(int $productQuantity = 1): bool
    {
        $totalQuantityNeeded = $this->quantity_needed * $productQuantity;
        $ingredient = $this->ingredient;

        if (!$ingredient) {
            return false;
        }

        // Para Ingredient
        if ($ingredient instanceof Ingredient) {
            return $ingredient->consumeStock($totalQuantityNeeded);
        }

        // Para MenuProduct (productos compuestos)
        if ($ingredient instanceof MenuProduct) {
            return $ingredient->consumeAllIngredients($totalQuantityNeeded);
        }

        return false;
    }

    /**
     * Obtiene el stock disponible actual
     */
    public function getAvailableStock(): int
    {
        $ingredient = $this->ingredient;

        if (!$ingredient) {
            return 0;
        }

        if ($ingredient instanceof Ingredient) {
            return $ingredient->getCurrentStock();
        }

        if ($ingredient instanceof MenuProduct) {
            return $ingredient->getMaxAvailableQuantity();
        }

        return 0;
    }

    /**
     * Calcula cuántas unidades del producto se pueden hacer con el stock actual
     */
    public function getMaxProductQuantityPossible(): int
    {
        $availableStock = $this->getAvailableStock();

        if ($this->quantity_needed <= 0) {
            return 0;
        }

        return intval(floor($availableStock / $this->quantity_needed));
    }
    //endregion
}