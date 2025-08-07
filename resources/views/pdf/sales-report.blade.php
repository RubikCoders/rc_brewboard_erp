<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #2F3036;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #685C44;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #677C5B;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .report-info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #685C44;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: normal;
            padding: 5px 15px 5px 0;
            width: 30%;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
        }

        .filters-section {
            margin-bottom: 20px;
        }

        .filters-title {
            font-weight: bold;
            color: #2F3036;
            margin-bottom: 10px;
        }

        .filter-item {
            background-color: #EFE9DB;
            padding: 4px 8px;
            margin: 3px 5px 3px 0;
            border-radius: 15px;
            display: inline-block;
            font-size: 8px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .products-table th,
        .products-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }

        .products-table th {
            background-color: #677C5B;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }

        .products-table td {
            font-size: 10px;
        }

        .products-table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .status-available {
            color: #0B8A4E;
            font-weight: bold;
        }

        .status-unavailable {
            color: #D96153;
            font-weight: bold;
        }

        .price {
            text-align: right;
            font-weight: bold;
        }

        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #E4E6C3;
            border-radius: 8px;
            border-left: 4px solid #685C44;
        }

        .summary-title {
            font-weight: bold;
            color: #2F3036;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #bcbcbc;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .no-products {
            text-align: center;
            padding: 40px;
            color: #677C5B;
            font-style: italic;
        }

        .product-image-placeholder {
            width: 20px;
            height: 20px;
            background-color: #e5e7eb;
            display: inline-block;
            border-radius: 3px;
            text-align: center;
            line-height: 20px;
            font-size: 8px;
            color: #6b7280;
        }

        .break-word {
            word-wrap: break-word;
            word-break: break-word;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
{{-- HEADER --}}
<div class="header">
    <div class="company-name">{{ config('app.name', 'Sistema de Gestión') }}</div>
    <div class="report-title">Reporte de Ventas</div>
</div>

{{-- INFORMACIÓN DEL REPORTE --}}
<div class="report-info">
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Fecha de generación:</div>
            <div class="info-value">{{ $generatedAt }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Generado por:</div>
            <div class="info-value">{{ $generatedBy }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Total de ventas:</div>
            <div class="info-value">{{ $orders->count() }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Rango:</div>
            <div class="info-value">{{ $dateRange }}</div>
        </div>
    </div>
</div>

{{-- TABLA DE PRODUCTOS --}}
@if($orders->count() > 0)
    <table class="products-table">
        <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 5%;">Orden</th>
            <th style="width: 25%;">Empleado</th>
            <th style="width: 10%;">Total</th>
            <th style="width: 10%;">IVA</th>
            <th style="width: 10%;">Método</th>
            <th style="width: 7%;">De</th>
            <th style="width: 20%;">Registrado el</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->employee->name . " " . $order->employee->last_name }} </td>
                <td><strong>{{ $order->total }}</strong></td>
                <td><strong>{{ $order->tax }}</strong></td>
                <td>{{ ucfirst($order->payment_method) }}</td>
                <td>
                    <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 6px; border-radius: 10px; font-size: 6px;">
                        {{ $order->from }}
                    </span>
                </td>
                <td>{{ $order->created_at->format("d/m/y H:m") }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- RESUMEN --}}
    <div class="summary">
        <div class="summary-title">Resumen del Reporte</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Ventas totales:</div>
                <div class="info-value">{{ $orders->count() }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Recibo promedio:</div>
                <div class="info-value">{{ $averageTicket }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Total de ganancias:</div>
                <div class="info-value">{{ $total }}</div>
            </div>
        </div>
    </div>

@else
    <div class="no-products">
        <h3>No se encontraron ventas</h3>
        <p>No hay ventas que coincidan con los filtros aplicados.</p>
    </div>
@endif

{{-- FOOTER --}}
<div class="footer">
    <p>Reporte generado automáticamente por {{ config('app.name') }} | {{ $generatedAt }}</p>
    <p>Este documento contiene información confidencial de la empresa.</p>
</div>
</body>
</html>
