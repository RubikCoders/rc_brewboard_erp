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
    "id" => "Identificador",
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
    "ingredient_name" => "Nombre del ingrediente",
    "ingredient_unit" => "Unidad de medida",
    "ingredient_category" => "Categoría",
    "ingredient_description" => "Descripción",
    "customization_option_name" => "Nombre de la opción",
    "customization_parent" => "Personalización",
    "extra_price" => "Precio adicional",
    "item_type" => "Tipo de artículo",
  ],

  "options" => [
    "ingredient" => "Ingrediente Base",
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
    "ingredient_with_inventory_exists" => "Este ingrediente ya tiene un registro de inventario",
    "customization_with_inventory_exists" => "Esta opción de personalización ya tiene un registro de inventario",
    "invalid_item_type" => "Tipo de artículo no válido",
  ],

  "placeholders" => [
    "reason" => "Ej: Recepción de mercancía, venta, merma, conteo físico...",
    "bulk_reason" => "Ej: Conteo físico mensual, ajuste por inventario...",
    "ingredient_unit_placeholder" => "ej: kg, litros, unidades",
    "ingredient_category_placeholder" => "ej: Lácteos, Granos, Bebidas",
    "customization_option_placeholder" => "ej: Leche de soya, Extra shot",
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
    "labels" => [
      "stock_status" => "Estado del Stock",
      "capacity_used" => "Capacidad Utilizada",
      "recommended_action" => "Acción Recomendada",
      "priority_level" => "Nivel de Prioridad",
      "estimated_duration" => "Duración Estimada",
      "restock_quantity" => "Cantidad a Reabastecer",
      "estimated_cost" => "Costo Estimado",
      "additional_tips" => "Consejos Adicionales",
      "last_update" => "Última Actualización",
    ],
    "priority" => [
      "maximum" => "MÁXIMA",
      "high" => "ALTA",
      "medium" => "MEDIA",
      "low" => "BAJA",
      "none" => "NINGUNA",
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

  "help_text" => [
    "stock_levels" => "El stock mínimo determina cuándo recibir alertas. El máximo define el nivel objetivo.",
    "quick_adjust" => "Realiza ajustes rápidos de inventario con registro de motivo.",
    "bulk_operations" => "Selecciona múltiples artículos para operaciones masivas.",
    "import_data" => "Importa datos desde archivos CSV o Excel para actualización masiva.",
  ],

  "stock_status" => [
    "optimal" => "Stock Óptimo - Sin Acciones",
    "low_warning" => "Stock Bajo - Reabastecer Pronto",
    "critical_urgent" => "Stock Crítico - Acción Inmediata",
    "out_critical" => "Sin Stock - Crítico",
    "excess_review" => "Stock Excesivo - Revisar",
  ],

  "recommendations" => [
    "urgent_restock" => "URGENTE: Reabastecer inmediatamente",
    "priority_restock" => "PRIORITARIO: Reabastecer pronto",
    "plan_restock" => "Planificar reabastecimiento",
    "review_levels" => "Revisar niveles máximos y usar stock actual",
    "maintain_current" => "Mantener niveles actuales - Sin acciones necesarias",
  ],
];