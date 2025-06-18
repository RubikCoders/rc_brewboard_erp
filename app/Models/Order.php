<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'customer_name',
        'total',
        'tax',
        'payment_method',
        'from',
        'status',
    ];

    //region Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(MenuProduct::class, 'order_products')
            ->using(OrderProduct::class)
            ->withPivot(['quantity', 'is_delivered', 'total_price', 'notes', 'kitchen_status']);
    }
    //endregion
}
