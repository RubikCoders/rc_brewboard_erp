<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(int[] $array)
 */
class ProductCustomization extends Model
{
    /** @use HasFactory<\Database\Factories\ProductCustomizationFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'required'
    ];
}
