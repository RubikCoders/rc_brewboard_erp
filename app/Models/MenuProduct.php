<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class MenuProduct extends Model
{
    /** @use HasFactory<\Database\Factories\MenuProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'ingredients',
        'base_price',
        'estimated_time_min',
        'is_available',
    ];
}
