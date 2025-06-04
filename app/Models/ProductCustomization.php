<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomization extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCustomizationFactory> */
    use HasFactory;

    protected $fillable = [
        'menu_product_id',
        'name'
    ];
}
