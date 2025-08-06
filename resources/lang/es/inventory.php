<?php

return [
  "model" => "Inventario",
  "item" => "Artículo de Inventario",
  "manage_inventory" => "Gestionar Inventario",
  "inventory_management" => "Gestión de Inventario",
  "unknown_item" => "Artículo desconocido",

  "navigation" => [
    "inventory" => "Inventario",
    "ingredients" => "Ingredientes",
    "stock_alerts" => "Alertas de Stock",
  ],

  "sections" => [
    "item_info" => [
      "title" => "Información del Artículo",
      "description" => "Selecciona el tipo y artículo para gestionar"
    ],
    "stock_levels" => [
      "title" => "Niveles de Stock",
      "description" => "Configura las cantidades mínimas, máximas y actuales"
    ],
  ],

  "fields" => [
    "id" => "ID",
    "stockable_type" => "Tipo de Artículo",
    "stockable_id" => "Artículo",
    "item_name" => "Nombre del Artículo",
    "type" => "Tipo",
    "stock" => "Stock Actual",
    "current_stock" => "Stock Actual",
    "min_stock" => "Stock Mínimo",
    "max_stock" => "Stock Máximo",
    "status" => "Estado",
    "percentage" => "Porcentaje",
    "action_type" => "Tipo de Acción",
    "quantity" => "Cantidad",
    "reason" => "Motivo",
    "units" => "unidades",
    "import_file" => "Archivo de Importación",
    "created_at" => "Creado el",
    "updated_at" => "Actualizado el",
  ],

  "options" => [
    "ingredient" => "Materia Prima",
    "menu_product" => "Producto del Menú",
    "customization_option" => "Opción de Personalización",
  ],

  "tabs" => [
    "all" => "Todo el Inventario",
    "ingredients" => "Materias Primas",
    "products" => "Productos",
    "customizations" => "Personalizaciones",
    "low_stock" => "Stock Bajo",
    "out_of_stock" => "Sin Stock",
    "critical" => "Stock Crítico",
    "excess" => "Stock Excesivo",
    "custom" => "Vista Personalizada",
  ],

  "filters" => [
    "low_stock" => "Stock Bajo",
    "out_of_stock" => "Sin Stock",
    "critical_stock" => "Stock Crítico",
    "excess_stock" => "Stock Excesivo",
  ],

  "actions" => [
    "create" => "Crear Inventario",
    "quick_adjust" => "Ajuste Rápido",
    "bulk_adjust" => "Ajuste Masivo",
    "add_stock" => "Agregar Stock",
    "remove_stock" => "Quitar Stock",
    "set_stock" => "Establecer Stock",
    "check_all" => "Verificar Todo",
    "report" => "Reporte",
    "import" => "Importar",
    "view_history" => "Ver Historial",
    "restock" => "Reabastecer",
  ],

  "notifications" => [
    "created" => "Inventario creado",
    "updated" => "Inventario actualizado",
    "adjusted" => "Stock ajustado correctamente",
    "imported" => "Inventario importado exitosamente",
    "already_exists" => "Inventario ya existe",
    "status_good" => "Estado del inventario: Bueno",
    "attention_required" => "Atención requerida en inventario",
  ],

  "messages" => [
    "item_created_successfully" => "El artículo se ha agregado al inventario correctamente",
    "item_updated_successfully" => "La información del inventario se ha actualizado",
    "inventory_already_exists" => "Ya existe un registro de inventario para este artículo",
    "all_items_ok" => "Todos los :total artículos están en niveles óptimos",
  ],

  "placeholders" => [
    "reason" => "Ej: Recepción de mercancía, venta, merma, conteo físico...",
    "bulk_reason" => "Ej: Conteo físico mensual, ajuste por inventario...",
  ],

  "tooltips" => [
    "check_all" => "Verificar el estado de todo el inventario",
    "report" => "Descargar reporte completo de inventario",
    "coming_soon" => "Funcionalidad próximamente disponible",
  ],

  "view" => [
    "sections" => [
      "item_details" => [
        "title" => "Detalles del Artículo",
        "description" => "Información básica del elemento en inventario"
      ],
      "stock_info" => [
        "title" => "Información de Stock",
        "description" => "Estado actual y recomendaciones"
      ],
      "system_info" => [
        "title" => "Información del Sistema",
        "description" => "Datos técnicos y fechas de registro"
      ]
    ],
  ],

  "stats" => [
    "total_items" => "Total de Artículos",
    "in_stock" => "En Stock",
    "low_stock" => "Stock Bajo",
    "out_of_stock" => "Sin Stock",
    "critical_stock" => "Stock Crítico",
    "excess_stock" => "Stock Excesivo",
    "percentage_availability" => "% Disponibilidad",
  ],

  "status_messages" => [
    "in_stock" => "En stock",
    "low_stock" => "Stock bajo",
    "out_of_stock" => "Sin stock",
    "critical_stock" => "Stock crítico",
    "excess_stock" => "Stock excesivo",
    "normal" => "Normal",
    "restock_needed" => "Reabastecer necesario",
    "optimal_level" => "Nivel óptimo",
  ],

  "alerts" => [
    "urgent_restock" => "Reabastecimiento urgente",
    "low_stock_warning" => "Advertencia de stock bajo",
    "out_of_stock_alert" => "Alerta: Sin stock",
    "excess_inventory" => "Inventario excesivo",
  ],

  "validation" => [
    "stock_required" => "El stock actual es obligatorio",
    "min_stock_required" => "El stock mínimo es obligatorio",
    "max_stock_required" => "El stock máximo es obligatorio",
    "max_greater_than_min" => "El stock máximo debe ser mayor al mínimo",
    "stock_positive" => "El stock debe ser un número positivo",
    "quantity_positive" => "La cantidad debe ser mayor a 0",
    "stockable_required" => "Debe seleccionar un artículo",
  ],

  "help_text" => [
    "stock_levels" => "El stock mínimo determina cuándo recibir alertas. El máximo define el nivel objetivo.",
    "quick_adjust" => "Realiza ajustes rápidos de inventario con registro de motivo.",
    "bulk_operations" => "Selecciona múltiples artículos para operaciones masivas.",
    "import_data" => "Importa datos desde archivos CSV o Excel para actualización masiva.",
  ],
];