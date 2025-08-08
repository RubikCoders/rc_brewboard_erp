{{-- #677C5B --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Inventario - BrewBoard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10px; 
            margin: 15px;
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px;
            border-bottom: 2px solid #677C5B;
            padding-bottom: 15px;
        }
        .header h1 { 
            margin: 0; 
            color: #677C5B; 
            font-size: 20px;
        }
        .header h2 { 
            margin: 5px 0; 
            color: #666; 
            font-size: 12px;
            font-weight: normal;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-section {
            background: #f8fafc;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        
        .info-section h3 {
            margin: 0 0 8px 0;
            font-size: 10px;
            color: #677C5B;
            font-weight: bold;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        
        .info-label {
            color: #64748b;
            font-weight: normal;
        }
        
        .info-value {
            font-weight: bold;
            color: #1e293b;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            text-align: center;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .stat-card.success { background: #f0fdf4; border-color: #22c55e; }
        .stat-card.warning { background: #fffbeb; border-color: #f59e0b; }
        .stat-card.danger { background: #fef2f2; border-color: #ef4444; }
        .stat-card.info { background: #eff6ff; border-color: #3b82f6; }

        .stat-number {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .stat-label {
            font-size: 8px;
            color: #64748b;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            font-size: 8px;
        }
        
        .table th {
            background: #677C5B;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            font-size: 8px;
        }
        
        .table td {
            padding: 6px 5px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 8px;
        }
        
        .table tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .badge {
            padding: 1px 4px;
            border-radius: 8px;
            font-size: 7px;
            font-weight: bold;
            color: white;
        }
        
        .badge.success { background: #22c55e; }
        .badge.warning { background: #f59e0b; }
        .badge.danger { background: #ef4444; }
        .badge.gray { background: #6b7280; }
        .badge.primary { background: #3b82f6; }
        .badge.info { background: #0ea5e9; }

        .text-center { text-align: center; }
        .text-right { text-right: right; }
        .font-bold { font-weight: bold; }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 8px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }

        .break-word {
            word-break: break-word;
        }

        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 4px;
        }

        .status-success { background: #22c55e; }
        .status-warning { background: #f59e0b; }
        .status-danger { background: #ef4444; }
        .status-info { background: #3b82f6; }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div class="header">
        <h1>BrewBoard - Reporte de Inventario</h1>
        <h2>Cafetería Pistacho</h2>
    </div>

    {{-- INFORMACIÓN GENERAL --}}
    <div class="info-grid">
        <div class="info-section">
            <h3>Información del Reporte</h3>
            <div class="info-row">
                <div class="info-label">Generado:</div>
                <div class="info-value">{{ $generatedAt }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Por:</div>
                <div class="info-value">{{ $generatedBy }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Vista:</div>
                <div class="info-value">{{ $appliedFilters['tab'] }}</div>
            </div>
        </div>
        
        <div class="info-section">
            <h3>Resumen de Inventario</h3>
            <div class="info-row">
                <div class="info-label">Total artículos:</div>
                <div class="info-value">{{ $stats['total_items'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Stock normal:</div>
                <div class="info-value">{{ $stats['normal_stock'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Requieren atención:</div>
                <div class="info-value">{{ $stats['needs_attention'] }}</div>
            </div>
        </div>

        <div class="info-section">
            <h3>Indicadores Clave</h3>
            <div class="info-row">
                <div class="info-label">% Sin existencia:</div>
                <div class="info-value">{{ $stats['out_of_stock_percentage'] }}%</div>
            </div>
            <div class="info-row">
                <div class="info-label">% Existencia baja:</div>
                <div class="info-value">{{ $stats['low_stock_percentage'] }}%</div>
            </div>
            <div class="info-row">
                <div class="info-label">Disponibilidad:</div>
                <div class="info-value">{{ round((($stats['total_items'] - $stats['out_of_stock']) / max($stats['total_items'], 1)) * 100, 1) }}%</div>
            </div>
        </div>
    </div>

    {{-- ESTADÍSTICAS VISUALES --}}
    <div class="stats-grid">
        <div class="stat-card success">
            <div class="stat-number">{{ $stats['normal_stock'] }}</div>
            <div class="stat-label">Existencia Normal</div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-number">{{ $stats['low_stock'] }}</div>
            <div class="stat-label">Existencia Baja</div>
        </div>
        
        <div class="stat-card danger">
            <div class="stat-number">{{ $stats['out_of_stock'] }}</div>
            <div class="stat-label">Sin Existencia</div>
        </div>
        
        <div class="stat-card info">
            <div class="stat-number">{{ $stats['excess_stock'] }}</div>
            <div class="stat-label">Existencia Excesiva</div>
        </div>
    </div>

    {{-- TABLA DE INVENTARIO --}}
    @if($inventoryItems->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th style="width: 4%;">#</th>
                <th style="width: 8%;">ID</th>
                <th style="width: 10%;">Tipo</th>
                <th style="width: 25%;">Artículo</th>
                <th style="width: 8%;">Stock</th>
                <th style="width: 8%;">Mín</th>
                <th style="width: 8%;">Máx</th>
                <th style="width: 12%;">Estado</th>
                <th style="width: 8%;">%</th>
                <th style="width: 9%;">Actualizado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventoryItems as $index => $item)
            @php
                $status = $item->getStockStatus();
                $percentage = $item->getStockPercentage();
                $stockable = $item->stockable;
                $itemName = $stockable?->name ?? 'Artículo desconocido';
                
                if ($item->stockable_type === \App\Models\CustomizationOption::class && $stockable) {
                    $itemName = $stockable->customization->name . ' - ' . $stockable->name;
                }
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="font-bold">{{ $item->id }}</td>
                <td>
                    <span class="badge {{ match($item->stockable_type) {
                        \App\Models\Ingredient::class => 'primary',
                        \App\Models\MenuProduct::class => 'success',
                        \App\Models\CustomizationOption::class => 'warning',
                        default => 'gray'
                    } }}">
                        {{ match($item->stockable_type) {
                            \App\Models\Ingredient::class => 'Ingrediente',
                            \App\Models\MenuProduct::class => 'Producto',
                            \App\Models\CustomizationOption::class => 'Personalización',
                            default => 'Desconocido'
                        } }}
                    </span>
                </td>
                <td class="break-word">
                    <strong>{{ $itemName }}</strong>
                </td>
                <td class="text-center font-bold">{{ $item->stock }}</td>
                <td class="text-center">{{ $item->min_stock }}</td>
                <td class="text-center">{{ $item->max_stock }}</td>
                <td class="text-center">
                    <span class="status-indicator status-{{ match($status) {
                        'out_of_stock' => 'danger',
                        'critical' => 'danger',
                        'low' => 'warning',
                        'excess' => 'info',
                        'normal' => 'success',
                        default => 'gray'
                    } }}"></span>
                    <span class="badge {{ match($status) {
                        'out_of_stock' => 'danger',
                        'critical' => 'danger',
                        'low' => 'warning',
                        'excess' => 'info',
                        'normal' => 'success',
                        default => 'gray'
                    } }}">
                        {{ match($status) {
                            'out_of_stock' => 'Sin Stock',
                            'critical' => 'Crítico',
                            'low' => 'Bajo',
                            'excess' => 'Exceso',
                            'normal' => 'Normal',
                            default => 'Desconocido'
                        } }}
                    </span>
                </td>
                <td class="text-center">{{ round($percentage, 1) }}%</td>
                <td class="text-center">{{ $item->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 30px; color: #6b7280;">
        <p>No se encontraron artículos de inventario con los filtros aplicados.</p>
    </div>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <p>Este reporte fue generado automáticamente por BrewBoard • Cafetería Pistacho</p>
        <p>Para gestionar el inventario, ingresa al sistema en línea</p>
    </div>
</body>
</html>