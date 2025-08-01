<?php

return [
  "model" => "Categorías de Productos",
  "category" => "Categoría",
  "manage_categories" => "Gestionar Categorías",
  "register_categories" => "Registrar Categorías",
  "categories_list" => "Lista de Categorías",
  "category_information" => "Información de la Categoría",
  "basic_information" => "Información Básica",

  "navigation" => [
    "cluster" => "Gestión del Menú",
    "categories" => "Categorías",
  ],

  "fields" => [
    "id" => "ID",
    "name" => "Nombre de la Categoría",
    "description" => "Descripción",
    "products_count" => "Productos",
    "created_at" => "Registrada el",
    "updated_at" => "Actualizada el",

    // Placeholders and help
    "name_placeholder" => "Ej: Bebidas Calientes, Postres, Snacks",
    "description_placeholder" => "Describe brevemente el tipo de productos de esta categoría...",
    "name_help" => "Nombre descriptivo para identificar fácilmente la categoría",
    "description_help" => "Descripción opcional que ayude a los empleados a clasificar productos",
  ],

  "sections" => [
    "basic_info" => [
      "title" => "Información Básica",
      "description" => "Datos principales de la categoría"
    ],
    "stats" => [
      "title" => "Estadísticas",
      "description" => "Información sobre productos en esta categoría"
    ]
  ],

  "actions" => [
    "create" => "Crear Categoría",
    "save" => "Guardar",
    "save_and_create_another" => "Guardar y crear otra",
    "cancel" => "Cancelar",
    "edit" => "Editar",
    "delete" => "Eliminar",
    "view" => "Ver",
    "view_products" => "Ver Productos",
    "manage_products" => "Gestionar Productos",
  ],

  "notifications" => [
    "created" => "Categoría creada exitosamente",
    "updated" => "Categoría actualizada exitosamente",
    "deleted" => "Categoría eliminada exitosamente",
    "cannot_delete_with_products" => "No se puede eliminar una categoría que tiene productos asociados",
  ],

  "validation" => [
    "name_required" => "El nombre de la categoría es obligatorio",
    "name_unique" => "Ya existe una categoría con este nombre",
    "name_max" => "El nombre no puede superar los 100 caracteres",
    "description_max" => "La descripción no puede superar los 500 caracteres",
  ],

  "filters" => [
    "with_products" => "Con productos",
    "without_products" => "Sin productos",
    "all" => "Todas las categorías",
  ],

  "states" => [
    "active" => "Activa",
    "inactive" => "Inactiva",
    "empty" => "Sin productos",
    "populated" => "Con productos",
  ],

  "stats" => [
    "total_categories" => "Total de Categorías",
    "active_categories" => "Categorías Activas",
    "categories_with_products" => "Categorías con Productos",
    "average_products_per_category" => "Promedio de Productos por Categoría",
  ],

  "empty_state" => [
    "title" => "No hay categorías creadas",
    "description" => "Comienza creando tu primera categoría de productos para organizar tu menú.",
    "action" => "Crear primera categoría",
  ],

  "bulk_actions" => [
    "delete_selected" => "Eliminar seleccionadas",
    "delete_confirmation" => "¿Estás seguro de que quieres eliminar las categorías seleccionadas?",
    "delete_warning" => "Las categorías que tengan productos asociados no serán eliminadas.",
  ],
];