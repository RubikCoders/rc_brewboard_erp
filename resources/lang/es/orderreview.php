<?php

return [
    "model" => "Reseñas",
    "order" => "Reseña",

    "positive" => "Positivas",
    "neutral" => "Neutrales",
    "negative" => "Negativas",

    "order_data" => "Datos de la orden",
    "order_data_description" => "Visualiza lo que :name pidio para esta reseña",
    "order_data_description_default" => "Visualiza lo que el cliente pidio para esta reseña",

    "radar" => "Radar",

    "review_data" => "Información de la reseña",
    "review_data_description" => "Mira lo que :name tiene por decir",
    "review_data_description_default" => "Mira lo que tu cliente tiene por decir",


    "fields" => [
        "id" => "N°",
        "order_id" => "Orden",
        "photo" => "Foto",
        "rating" => "Calificación",
        "comment" => "Comentario",
        "image" => "Imagen",
        "created_at" => "Fecha de registro",
        "customer_name" => "Nombre del cliente",
        "order_created_at" => "Fecha de la orden",
        "order_id_label" => "Número de orden"
    ],

    "tabs" => [
        "all" => "Todas",
        "positive" => "Positivas",
        "negative" => "Negativas",
        "neutral" => "Neutrales"
    ],

    "actions" => [
        "view_order" => "Ver Orden"
    ],

    "widgets" => [
        "average" => [
            "label" => "Promedio",
            "description" => "Calificación total"
        ],

        "positive" => [
            "label" => "Positivas",
            "description" => "Reseñas positivas"
        ],

        "negative" => [
            "label" => "Negativas",
            "description" => "Reseñas negativas"
        ],

        "neutral" => [
            "label" => "Neutrales",
            "description" => "Reseñas neutrales"
        ]
    ]
];