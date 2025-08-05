<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReview extends Model
{
    /** @use HasFactory<\Database\Factories\OrderReviewFactory> */
    use HasFactory;

    //region Attributes
    protected $fillable = [
        'order_id',
        'rating',
        'comment',
        'image_path'
    ];

    //region Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    //endregion
}
