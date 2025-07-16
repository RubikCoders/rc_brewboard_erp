<?php

return [
    "model" => "Ordenes",
    "order" => "Orden",
    "erp" => "Caja",
    "csp" => "Kiosko",
    "date" => "Fecha",
    "time" => "Hora",
    "select_products" => "Seleccionar Productos",
    "payment" => "Realizar Pago",
    "payment_description" => "Realiza el cobro de la orden",
    "products" => "Productos",
    "required_customizations" => "Personalizaciones Requeridas",
    "optional_customizations" => "Personalizaciones Opcionales",
    "select_products_description" => "Selecciona los productos que solicita el cliente",
    "summary" => "Resumen",
    "subtotal" => "Subtotal",

    "fields" => [
        "id" => "N°",
        "employee_id" => "Empleado en caja",
        "customer_name" => "Nombre del cliente",
        "total" => "Total",
        "tax" => "Impuesto",
        "payment_method" => "Método de pago",
        "from" => "De",
        "status" => [
            "label" => "Estado",
            0 => "Pendiente",
            1 => "Pagada",
            2 => "Cancelada"
        ],
        "created_at" => "Registrado el",
        "payment_methods" => [
            "card" => "Tarjeta",
            "cash" => "Efectivo"
        ],

        // relationships
        "product_id" => "Producto",
        "categories" => [
            "cold" => "Frias",
            "hot" => "Calientes",
            "food" => "Alimento",
        ],
        'notes' => "Notas",
    ],

    "actions" => [
        "create" => "Registrar"
    ],

    "notification" => [
        "create" => "Orden registrada correctamente"
    ]
];
