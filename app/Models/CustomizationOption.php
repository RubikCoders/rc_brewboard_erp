<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class CustomizationOption extends Model
{
    /** @use HasFactory<\Database\Factories\CustomizationOptionFactory> */
    use HasFactory;

    protected $table = 'customizations_options';

    protected $fillable = [
        'customization_id',
        'name',
        'extra_price'
    ];

    //region Relationships
    public function customization()
    {
        return $this->belongsTo(ProductCustomization::class, 'customization_id');
    }
    //endregion
}
