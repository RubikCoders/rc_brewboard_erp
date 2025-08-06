<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends Model
{
    //region Attributes
    protected $table = 'inventory_items';

    protected $fillable = [
        'stockable_id',
        'stockable_type',
        'stock',
        'min_stock',
        'max_stock',
    ];

    protected $casts = [
        'stock' => 'integer',
        'min_stock' => 'integer',
        'max_stock' => 'integer',
    ];
    //endregion

    //region Relationships
    /**
     * Relación polimórfica con el elemento que tiene stock
     * Puede ser: MenuProduct, CustomizationOption, Ingredient
     */
    public function stockable()
    {
        return $this->morphTo();
    }
    //endregion

    //region Scopes
    /**
     * Scope para items con stock bajo
     */
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereRaw('stock <= min_stock');
    }

    /**
     * Scope para items sin stock
     */
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('stock', '<=', 0);
    }

    /**
     * Scope para items con stock crítico (menor al 20% del mínimo)
     */
    public function scopeCriticalStock(Builder $query): Builder
    {
        return $query->whereRaw('stock <= (min_stock * 0.2)');
    }

    /**
     * Scope para items con stock excesivo (mayor al máximo)
     */
    public function scopeExcessStock(Builder $query): Builder
    {
        return $query->whereRaw('stock > max_stock');
    }

    /**
     * Scope para items con stock normal
     */
    public function scopeNormalStock(Builder $query): Builder
    {
        return $query->whereRaw('stock > min_stock AND stock <= max_stock');
    }

    /**
     * Scope por tipo de stockable
     */
    public function scopeByStockableType(Builder $query, string $type): Builder
    {
        return $query->where('stockable_type', $type);
    }
    //endregion

    //region Methods
    /**
     * Verifica si tiene stock suficiente
     */
    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }

    /**
     * Verifica si está en stock bajo
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    /**
     * Verifica si está agotado
     */
    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    /**
     * Verifica si está en stock crítico
     */
    public function isCriticalStock(): bool
    {
        return $this->stock <= ($this->min_stock * 0.2);
    }

    /**
     * Verifica si tiene stock excesivo
     */
    public function hasExcessStock(): bool
    {
        return $this->stock > $this->max_stock;
    }

    /**
     * Obtiene el porcentaje de stock actual respecto al máximo
     */
    public function getStockPercentage(): float
    {
        if ($this->max_stock <= 0) {
            return 0;
        }

        return ($this->stock / $this->max_stock) * 100;
    }

    /**
     * Obtiene el estado del stock
     */
    public function getStockStatus(): string
    {
        if ($this->isOutOfStock()) {
            return 'out_of_stock';
        }

        if ($this->isCriticalStock()) {
            return 'critical';
        }

        if ($this->isLowStock()) {
            return 'low';
        }

        if ($this->hasExcessStock()) {
            return 'excess';
        }

        return 'normal';
    }

    /**
     * Obtiene el color para mostrar en UI según el estado del stock
     */
    public function getStockStatusColor(): string
    {
        return match ($this->getStockStatus()) {
            'out_of_stock' => 'danger',
            'critical' => 'danger',
            'low' => 'warning',
            'excess' => 'info',
            'normal' => 'success',
            default => 'secondary'
        };
    }

    /**
     * Obtiene mensaje descriptivo del estado
     */
    public function getStockStatusMessage(): string
    {
        $status = $this->getStockStatus();

        return match ($status) {
            'out_of_stock' => 'Sin stock',
            'critical' => "Stock crítico ({$this->stock} restantes)",
            'low' => "Stock bajo ({$this->stock}/{$this->min_stock})",
            'excess' => "Stock excesivo ({$this->stock}/{$this->max_stock})",
            'normal' => "Stock normal ({$this->stock})",
            default => "Estado desconocido"
        };
    }

    /**
     * Consume stock
     */
    public function consume(int $quantity): bool
    {
        if (!$this->hasStock($quantity)) {
            return false;
        }

        $this->decrement('stock', $quantity);
        return true;
    }

    /**
     * Agrega stock
     */
    public function add(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    /**
     * Ajusta el stock a una cantidad específica
     */
    public function adjustTo(int $newStock, string $reason = null): void
    {
        $oldStock = $this->stock;
        $this->update(['stock' => $newStock]);

        // Aquí podrías registrar el ajuste en una tabla de movimientos si la implementas
        // InventoryMovement::create([
        //     'inventory_id' => $this->id,
        //     'type' => 'adjustment',
        //     'quantity' => $newStock - $oldStock,
        //     'reason' => $reason,
        // ]);
    }

    /**
     * Calcula la cantidad recomendada para reposición
     */
    public function getRecommendedRestock(): int
    {
        if ($this->stock >= $this->min_stock) {
            return 0; // No necesita reposición
        }

        // Reponer hasta llegar al máximo, pero al menos hasta cubrir el mínimo
        return $this->max_stock - $this->stock;
    }

    /**
     * Verifica si necesita reposición urgente
     */
    public function needsUrgentRestock(): bool
    {
        return $this->isCriticalStock() || $this->isOutOfStock();
    }

    /**
     * Obtiene información completa para alertas
     */
    public function getAlertInfo(): array
    {
        $status = $this->getStockStatus();
        $stockable = $this->stockable;

        return [
            'id' => $this->id,
            'stockable_type' => $this->stockable_type,
            'stockable_id' => $this->stockable_id,
            'stockable_name' => $stockable?->name ?? 'Elemento desconocido',
            'current_stock' => $this->stock,
            'min_stock' => $this->min_stock,
            'max_stock' => $this->max_stock,
            'status' => $status,
            'status_color' => $this->getStockStatusColor(),
            'status_message' => $this->getStockStatusMessage(),
            'recommended_restock' => $this->getRecommendedRestock(),
            'needs_urgent_restock' => $this->needsUrgentRestock(),
            'stock_percentage' => round($this->getStockPercentage(), 1),
        ];
    }

    /**
     * Obtiene estadísticas globales de inventario
     */
    public static function getGlobalStats(): array
    {
        $total = self::count();
        $outOfStock = self::outOfStock()->count();
        $lowStock = self::lowStock()->count();
        $criticalStock = self::criticalStock()->count();
        $excessStock = self::excessStock()->count();
        $normalStock = self::normalStock()->count();

        return [
            'total_items' => $total,
            'out_of_stock' => $outOfStock,
            'critical_stock' => $criticalStock,
            'low_stock' => $lowStock,
            'normal_stock' => $normalStock,
            'excess_stock' => $excessStock,
            'out_of_stock_percentage' => $total > 0 ? round(($outOfStock / $total) * 100, 1) : 0,
            'low_stock_percentage' => $total > 0 ? round(($lowStock / $total) * 100, 1) : 0,
            'needs_attention' => $outOfStock + $criticalStock + $lowStock,
        ];
    }
    //endregion
}