<?php

return [
    'validation' => [
        'order_product_id' => [
            'required' => 'El ID del producto de la orden es obligatorio.',
            'exists' => 'El producto de la orden seleccionado no existe.',
        ],
        'product_customization_id' => [
            'required' => 'El ID de la personalización es obligatorio.',
            'exists' => 'La personalización seleccionada no existe.',
        ],
    ],
];