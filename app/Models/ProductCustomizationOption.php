<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ProductCustomizationOption extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCustomizationOptionFactory> */
    use HasFactory;

    protected $table = 'product_customizations_options';

    protected $fillable = [
        'customization_id',
        'name',
        'extra_price'
    ];
}
