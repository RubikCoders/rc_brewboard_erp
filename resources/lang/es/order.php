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
    "customer" => "Cliente",
    "payment_label" => "Pago",
    "taken_in" => "Tomada en",

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
            1 => "Entregada",
            2 => "Cancelada"
        ],
        "created_at" => "Registrado el",
        "payment_methods" => [
            "card" => "Tarjeta",
            "cash" => "Efectivo"
        ],

        // relationships
        "product_id" => "Producto",
        "description" => "Descripción",
        "categories" => [
            "cold" => "Frias",
            "hot" => "Calientes",
            "food" => "Alimento",
        ],
        "kitchen_status" => [
            0 => "En barra",
            1 => "Listo",
            2 => "Entregado"
        ],
        'notes' => "Notas",
    ],

    "actions" => [
        "create" => "Registrar",
        "status_ready" => "Marcar como listo",
        "status_delivered" => "Marcar como entregado",
        "order_delivered" => "Marcar como entregada",
        "order_canceled" => "Cancelar orden",
    ],

    "notification" => [
        "create" => "Orden registrada correctamente",
        "no_products_delivered" => [
            "title" => "Orden sin entregar",
            "body" => "Debes marcar todos los productos como \"Entregados\""
        ],
    ]
];
