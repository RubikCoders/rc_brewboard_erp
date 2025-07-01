<?php

return [
    "validation" => [
        "employee_id" => [
            "exists" => "The selected employee does not exist.",
        ],
    
        "customer_name" => [
            "required" => "The customer name is required.",
            "string" => "The customer name must be a text.",
            "max" => "The customer name may not be greater than 255 characters.",
        ],
    
        "total" => [
            "required" => "The total amount is required.",
            "integer" => "The total amount must be an integer (in cents).",
        ],
    
        "tax" => [
            "required" => "The tax amount is required.",
            "integer" => "The tax amount must be an integer (in cents).",
        ],
    
        "payment_method" => [
            "required" => "The payment method is required.",
            "string" => "The payment method must be a text.",
            "max" => "The payment method may not be greater than 255 characters.",
        ],
    
        "from" => [
            "required" => "The origin field is required.",
            "string" => "The origin field must be a text.",
            "max" => "The origin field may not be greater than 255 characters.",
        ],
    
        "status" => [
            "required" => "The status is required.",
            "integer" => "The status must be an integer.",
        ],
    ]
];