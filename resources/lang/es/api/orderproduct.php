<?php

return [
    'validation' => [
        'order_id' => [
            'required' => 'El ID de la orden es obligatorio.',
            'exists' => 'La orden seleccionada no existe.',
        ],
        'product_id' => [
            'required' => 'El ID del producto es obligatorio.',
            'exists' => 'El producto seleccionado no existe.',
        ],
        'quantity' => [
            'required' => 'La cantidad es obligatoria.',
            'integer' => 'La cantidad debe ser un número entero.',
            'min' => 'La cantidad mínima permitida es 1.',
        ],
        'is_delivered' => [
            'boolean' => 'El campo de entrega debe ser verdadero o falso.',
        ],
        'total_price' => [
            'required' => 'El precio total es obligatorio.',
            'integer' => 'El precio total debe ser un número entero.',
            'min' => 'El precio total no puede ser negativo.',
        ],
        'notes' => [
            'string' => 'Las notas deben ser texto.',
            'max' => 'Las notas no pueden superar los 1000 caracteres.',
        ],
        'kitchen_status' => [
            'required' => 'El estado en cocina es obligatorio.',
            'integer' => 'El estado en cocina debe ser un número entero.',
        ],
    ],
];
