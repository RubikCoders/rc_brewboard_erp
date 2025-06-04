<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationOption extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCustomizationOptionFactory> */
    use HasFactory;

    protected $fillable = [
        'customization_id',
        'name',
        'extra_price'
    ];
}
