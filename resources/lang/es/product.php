<?php

return [
  "model" => "Productos del Menú",
  "product" => "Producto",
  "manage_products" => "Gestionar Productos",
  "register_products" => "Registrar Productos",
  "products_list" => "Lista de Productos",
  "product_information" => "Información del Producto",
  "product_customizations" => "Personalizaciones",
  "basic_information" => "Información Básica",
  "description_and_details" => "Descripción y Detalles",
  "pricing_and_availability" => "Precio y Disponibilidad",

  // Navigation
  "navigation" => [
    "cluster" => "Gestión del Menú",
    "products" => "Productos",
  ],

  "fields" => [
    "id" => "ID",
    "category_id" => "Categoría",
    "image_url" => "Imagen del Producto",
    "name" => "Nombre del Producto",
    "description" => "Descripción",
    "ingredients" => "Ingredientes",
    "base_price" => "Precio Base",
    "estimated_time_min" => "Tiempo Estimado (min)",
    "is_available" => "Disponible",
    "created_at" => "Registrado el",
    "updated_at" => "Actualizado el",

    // Customizations
    "customization_name" => "Nombre de la Personalización",
    "customization_required" => "¿Es Requerida?",
    "option_name" => "Nombre de la Opción",
    "option_extra_price" => "Precio Adicional",

    // Placeholders and help
    "name_placeholder" => "Ej: Latte Caramelo",
    "description_placeholder" => "Describe el producto brevemente...",
    "ingredients_placeholder" => "Ej: Café espresso, leche, jarabe de caramelo",
    "customization_name_placeholder" => "Ej: Tamaño, Tipo de leche, Extras",
    "option_name_placeholder" => "Ej: Pequeño, Mediano, Grande",
  ],

  "sections" => [
    "basic_info" => [
      "title" => "Información Básica",
      "description" => "Datos principales del producto"
    ],
    "details" => [
      "title" => "Descripción y Detalles",
      "description" => "Descripción, ingredientes e imagen"
    ],
    "pricing" => [
      "title" => "Precio y Disponibilidad",
      "description" => "Configuración de precio y estado"
    ],
    "customizations" => [
      "title" => "Personalizaciones del Producto",
      "description" => "Configura las opciones de personalización disponibles para este producto"
    ]
  ],

  "tabs" => [
    "register" => "Registrar Productos",
    "list" => "Lista de Productos"
  ],

  "actions" => [
    "create" => "Crear Producto",
    "save" => "Guardar",
    "save_and_create_another" => "Guardar y crear otro",
    "cancel" => "Cancelar",
    "edit" => "Editar",
    "delete" => "Eliminar",
    "view" => "Ver",
    "add_customization" => "Agregar Personalización",
    "add_option" => "Agregar Opción",
    "remove_customization" => "Eliminar Personalización",
    "remove_option" => "Eliminar Opción",
  ],

  "notifications" => [
    "created" => "Producto creado exitosamente",
    "updated" => "Producto actualizado exitosamente",
    "deleted" => "Producto eliminado exitosamente",
  ],

  "validation" => [
    "name_required" => "El nombre del producto es obligatorio",
    "category_required" => "Debes seleccionar una categoría",
    "base_price_required" => "El precio base es obligatorio",
    "base_price_positive" => "El precio base debe ser mayor a 0",
    "estimated_time_positive" => "El tiempo estimado debe ser mayor a 0",
  ]
];