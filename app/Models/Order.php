<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    public const IVA = 0.16;

    protected $fillable = [
        'employee_id',
        'customer_name',
        'total',
        'tax',
        'payment_method',
        'from',
        'status',
    ];

    //region Methods
    protected static function boot()
    {
        static::bootTraits();

        static::creating(function (self $order) { 
            $order->calculateTax($order, $order->total);
        });
    }


    /**
     * Calculate tax (iva) for an order, managed by creating boot method
     * @param self $order creating method
     * @param int $total to calculate tax
     * @author Angel Mendoza
     */
    private function calculateTax(self $order, int $total): self {
        $order->tax = $total * self::IVA;
        return $order;
    }

    //endregion

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

    public function reviews()
    {
        return $this->hasMany(OrderReview::class);
    }
    //endregion
}
