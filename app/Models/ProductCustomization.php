<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ProductCustomization extends Model
{
    use HasFactory;

    //region Attributes
    protected $fillable = [
        'product_id',
        'name',
        'required'
    ];

    protected $casts = [
        'required' => 'boolean',
    ];
    //endregion

    //region Relationships
    /**
     * Producto al que pertenece esta personalización
     */
    public function product()
    {
        return $this->belongsTo(MenuProduct::class, 'product_id');
    }

    /**
     * Opciones disponibles para esta personalización
     */
    public function options()
    {
        return $this->hasMany(CustomizationOption::class, 'customization_id');
    }

    /**
     * Personalizaciones de órdenes que usan esta personalización
     */
    public function orderProductCustomizations()
    {
        return $this->hasMany(OrderCustomization::class, 'product_customization_id');
    }

    /**
     * Relación polimórfica con inventario (para personalizaciones que consumen stock)
     * Ejemplo: "Tamaño Grande" podría consumir más ingredientes base
     */
    public function inventory()
    {
        return $this->morphOne(Inventory::class, 'stockable');
    }
    //endregion

    //region Scopes
    /**
     * Scope para personalizaciones requeridas
     */
    public function scopeRequired(Builder $query): Builder
    {
        return $query->where('required', true);
    }

    /**
     * Scope para personalizaciones opcionales
     */
    public function scopeOptional(Builder $query): Builder
    {
        return $query->where('required', false);
    }

    /**
     * Scope para personalizaciones que tienen opciones disponibles
     */
    public function scopeWithAvailableOptions(Builder $query): Builder
    {
        return $query->whereHas('options', function (Builder $query) {
            $query->available();
        });
    }
    //endregion

    //region Methods
    /**
     * Verifica si esta personalización tiene al menos una opción disponible
     * Crítico para personalizaciones requeridas
     */
    public function hasAvailableOptions(): bool
    {
        return $this->options()->available()->exists();
    }

    /**
     * Obtiene todas las opciones disponibles
     */
    public function getAvailableOptions()
    {
        return $this->options()->available()->get();
    }

    /**
     * Obtiene opciones con stock bajo
     */
    public function getLowStockOptions()
    {
        return $this->options()->lowStock()->get();
    }

    /**
     * Obtiene opciones agotadas
     */
    public function getOutOfStockOptions()
    {
        return $this->options()->outOfStock()->get();
    }

    /**
     * Verifica si la personalización está completamente disponible
     * (para personalizaciones requeridas, debe tener opciones disponibles)
     */
    public function isAvailable(): bool
    {
        if ($this->required) {
            return $this->hasAvailableOptions();
        }

        // Para personalizaciones opcionales, siempre están "disponibles"
        // aunque sus opciones estén agotadas
        return true;
    }

    /**
     * Obtiene el estado de disponibilidad de la personalización
     */
    public function getAvailabilityStatus(): array
    {
        $availableOptions = $this->getAvailableOptions();
        $totalOptions = $this->options()->count();
        $availableCount = $availableOptions->count();

        if ($this->required && $availableCount === 0) {
            return [
                'status' => 'unavailable',
                'message' => 'Personalización requerida sin opciones disponibles',
                'available_options' => 0,
                'total_options' => $totalOptions,
                'is_blocking' => true
            ];
        }

        if ($availableCount === 0) {
            return [
                'status' => 'all_out_of_stock',
                'message' => 'Todas las opciones agotadas',
                'available_options' => 0,
                'total_options' => $totalOptions,
                'is_blocking' => false
            ];
        }

        if ($availableCount < $totalOptions) {
            return [
                'status' => 'partial_availability',
                'message' => "Algunas opciones disponibles ({$availableCount}/{$totalOptions})",
                'available_options' => $availableCount,
                'total_options' => $totalOptions,
                'is_blocking' => false
            ];
        }

        return [
            'status' => 'fully_available',
            'message' => 'Todas las opciones disponibles',
            'available_options' => $availableCount,
            'total_options' => $totalOptions,
            'is_blocking' => false
        ];
    }

    /**
     * Obtiene opciones ordenadas por disponibilidad (disponibles primero)
     */
    public function getOptionsOrderedByAvailability()
    {
        return $this->options()
            ->leftJoin('inventory_items', function ($join) {
                $join->on('customizations_options.id', '=', 'inventory_items.stockable_id')
                    ->where('inventory_items.stockable_type', '=', CustomizationOption::class);
            })
            ->orderByRaw('CASE 
                WHEN inventory_items.stock IS NULL THEN 1 
                WHEN inventory_items.stock > 0 THEN 2 
                ELSE 3 
            END')
            ->orderBy('customizations_options.name')
            ->select('customizations_options.*')
            ->get();
    }

    /**
     * Verifica si una opción específica puede ser seleccionada
     */
    public function canSelectOption(int $optionId): bool
    {
        $option = $this->options()->find($optionId);

        if (!$option) {
            return false;
        }

        return $option->isAvailable();
    }

    /**
     * Obtiene estadísticas de stock para esta personalización
     */
    public function getStockStatistics(): array
    {
        $options = $this->options()->with('inventory')->get();

        $stats = [
            'total_options' => $options->count(),
            'available_options' => 0,
            'low_stock_options' => 0,
            'out_of_stock_options' => 0,
            'unlimited_options' => 0
        ];

        foreach ($options as $option) {
            $status = $option->getStockStatus();

            switch ($status) {
                case 'unlimited':
                    $stats['unlimited_options']++;
                    $stats['available_options']++;
                    break;
                case 'in_stock':
                    $stats['available_options']++;
                    break;
                case 'low_stock':
                    $stats['low_stock_options']++;
                    $stats['available_options']++;
                    break;
                case 'out_of_stock':
                    $stats['out_of_stock_options']++;
                    break;
            }
        }

        return $stats;
    }
    //endregion
}