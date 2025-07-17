<?php

return [
    'validation' => [
        'order_id' => [ 
            'required'=> 'Order ID is required',
        ],

        'rating' => [ 
            'required'=> 'Rating is required',
            'min' => 'Rating must be a number equal or greater than zero',
            'max' => 'Rating must be a number equal or less than ten'
        ]
    ]
];