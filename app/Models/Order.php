<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @property \Illuminate\Database\Eloquent\Collection|mixed $orderProducts
 */
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    public const FROM_CSP = 'csp';
    public const FROM_ERP = 'erp';

    public const STATUS_WAITING = 0;
    public const STATUS_FINISHED = 1;
    public const STATUS_CANCELLED = 2;

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
     * Calculate tax (iva) for an order, managed by creating in boot method
     * @param self $order creating method
     * @param int $total to calculate tax
     * @author Angel Mendoza
     */
    private function calculateTax(self $order, int $total): self
    {
        $order->tax = $total * Money::IVA;
        return $order;
    }

    /**
     * Check if the order products are all delivered
     * @param Order $order
     * @return bool true when all are delivered
     * @author Angel Mendoza
     */
    public static function allProductsDelivered(self $order): bool
    {
        return $order->orderProducts()->where('kitchen_status', '!=', 2)->doesntExist();
    }

    /**
     * Calculate estimated time, stop in 15 minutes
     * @param Order $order
     * @return int
     */
    public static function calculateEstimatedTime(self $order): int
    {
        $estimatedTime = 0;

        foreach ($order->orderProducts as $orderProduct) {
            $estimatedTime += $orderProduct->product->estimated_time_min;
            if ($estimatedTime >= 15) return 15;
        }


        return $estimatedTime;
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


    public function reviews()
    {
        return $this->hasMany(OrderReview::class);
    }
    //endregion
}
