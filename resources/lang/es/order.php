<?php

return [
    "model" => "Órdenes",
    "order" => "Orden",
    "erp" => "Caja",
    "csp" => "Kiosko",
    "date" => "Fecha",
    "time" => "Hora",
    "select_products" => "Seleccionar Productos",
    "payment" => "Datos de Pago",
    "payment_description" => "Prepara el cobro de la orden",
    "preview" => "Resumen",
    "preview_description" => "Finaliza el pedido",
    "products" => "Productos",
    "required_customizations" => "Personalizaciones Requeridas",
    "optional_customizations" => "Personalizaciones Opcionales",
    "select_products_description" => "Selecciona los productos que solicita el cliente",
    "summary" => "Resumen",
    "subtotal" => "Subtotal",
    "order_total" => "Total de la Orden",
    "customer" => "Cliente",
    "payment_label" => "Pago",
    "taken_in" => "Tomada en",
    "section_payment_description" => "Detalles del pago de la orden, solo disponible para Administradores",
    "section_order_description" => "Detalles de la orden",
    "view_order" => "Ver Orden #:number",

    "fields" => [
        "id" => "N°",
        "employee_id" => "Empleado en caja",
        "customer_name" => "Nombre del cliente",
        "total" => "Total",
        "tax" => "Impuesto",
        "payment_method" => "Método de pago",
        "admin_password" => "Contraseña del administrador",
        "from" => "De",
        "payment_folio" => "Folio de pago",
        "status" => [
            "label" => "Estado",
            0 => "Pendiente",
            1 => "Pagada",
            2 => "Cancelada"
        ],
        "cancel_reason" => "Razón de la cancelación",
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
        "restore_order" => "Anular cancelación",
        "ticket" => "Recibo",
        "report" => "Reporte",
    ],

    "filters" => [
        "payment_card" => "Pago con tarjeta",
        "payment_cash" => "Pago en efectivo"
    ],

    "tabs" => [
        "all" => "Todos",
        "pending" => "Pendientes",
        "ready" => "Entregadas",
        "cancelled" => "Cancelados",
    ],

    "tooltips" => [
        "report" => "Descargar reporte completo de ventas"
    ],

    "notification" => [
        "create" => "Orden registrada correctamente",
        "no_products_delivered" => [
            "title" => "Orden sin entregar",
            "body" => "Debes marcar todos los productos como \"Entregados\""
        ],
        "wrong_password" => "Contraseña incorrecta, no es posible anular la cancelación"
    ]
];
