<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CustomizationOption extends Model
{
    use HasFactory;

    //region Attributes
    protected $table = 'customizations_options';

    protected $fillable = [
        'customization_id',
        'name',
        'extra_price'
    ];

    protected $casts = [
        'extra_price' => 'decimal:2',
    ];
    //endregion

    //region Relationships
    /**
     * Personalización a la que pertenece esta opción
     */
    public function customization()
    {
        return $this->belongsTo(ProductCustomization::class, 'customization_id');
    }

    /**
     * Personalizaciones de órdenes que usan esta opción
     */
    public function orderCustomizations()
    {
        return $this->hasMany(OrderCustomization::class, 'product_customization_id');
    }

    /**
     * Relación polimórfica con inventario
     * Para opciones que consumen inventario (ej: "Leche de Soya", "Jarabe Vainilla")
     */
    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'stockable');
    }
    //endregion

    //region Scopes
    /**
     * Scope para opciones disponibles (con stock)
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->whereHas('inventory', function (Builder $query) {
            $query->where('stock', '>', 0);
        })->orWhereDoesntHave('inventory'); // Si no tiene inventario, asumimos que está disponible
    }

    /**
     * Scope para opciones con stock bajo
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereHas('inventory', function (Builder $query) {
            $query->whereRaw('stock <= min_stock');
        });
    }

    /**
     * Scope para opciones sin stock
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
     * Verifica si la opción está disponible (tiene stock o no requiere inventario)
     */
    public function isAvailable(): bool
    {
        // Si no tiene inventario asociado, está disponible
        if (!$this->inventory) {
            return true;
        }

        // Si tiene inventario, verificar que tenga stock
        return $this->inventory->stock > 0;
    }

    /**
     * Verifica si tiene stock suficiente para la cantidad solicitada
     */
    public function hasStock(int $quantity = 1): bool
    {
        // Si no tiene inventario, asumimos disponibilidad ilimitada
        if (!$this->inventory) {
            return true;
        }

        return $this->inventory->stock >= $quantity;
    }

    /**
     * Obtiene el stock actual
     */
    public function getCurrentStock(): int
    {
        return $this->inventory?->stock ?? -1; // -1 indica stock ilimitado
    }

    /**
     * Verifica si está en stock bajo
     */
    public function isLowStock(): bool
    {
        if (!$this->inventory) {
            return false;
        }

        return $this->inventory->stock <= $this->inventory->min_stock;
    }

    /**
     * Verifica si está agotado
     */
    public function isOutOfStock(): bool
    {
        if (!$this->inventory) {
            return false;
        }

        return $this->inventory->stock <= 0;
    }

    /**
     * Obtiene el estado del stock
     */
    public function getStockStatus(): string
    {
        if (!$this->inventory) {
            return 'unlimited';
        }

        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        }

        if ($this->isLowStock()) {
            return 'low_stock';
        }

        return 'in_stock';
    }

    /**
     * Consume stock de la opción
     */
    public function consumeStock(int $quantity = 1): bool
    {
        // Si no tiene inventario, no hay nada que consumir
        if (!$this->inventory) {
            return true;
        }

        if (!$this->hasStock($quantity)) {
            return false;
        }

        $this->inventory->decrement('stock', $quantity);
        return true;
    }

    /**
     * Agrega stock a la opción
     */
    public function addStock(int $quantity): void
    {
        if ($this->inventory) {
            $this->inventory->increment('stock', $quantity);
        }
    }

    /**
     * Obtiene información de disponibilidad para mostrar en UI
     */
    public function getAvailabilityInfo(): array
    {
        if (!$this->inventory) {
            return [
                'available' => true,
                'status' => 'unlimited',
                'message' => 'Disponible',
                'stock' => null
            ];
        }

        $status = $this->getStockStatus();
        $stock = $this->getCurrentStock();

        $messages = [
            'in_stock' => "Disponible ({$stock} en stock)",
            'low_stock' => "Pocas existencias ({$stock} restantes)",
            'out_of_stock' => 'Agotado'
        ];

        return [
            'available' => $status !== 'out_of_stock',
            'status' => $status,
            'message' => $messages[$status] ?? 'Estado desconocido',
            'stock' => $stock
        ];
    }

    /**
     * Calcula el precio total (precio base + precio extra)
     * Útil para cálculos de órdenes
     */
    public function getTotalPrice(float $basePrice = 0): float
    {
        return $basePrice + $this->extra_price;
    }
    //endregion
}