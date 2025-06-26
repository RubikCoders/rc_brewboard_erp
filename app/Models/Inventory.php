<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory_items';

    //region Attributes
    protected $fillable = [
        'stockable_id',
        'stockable_type',
        'stock',
        'min_stock',
        'max_stock',
    ];
    //endregion

    //region Relationships
    public function stockable()
    {
        return $this->morphTo();
    }
    //endregion
}
