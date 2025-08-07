<?php

namespace App\Models;

use App\Helpers\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @property \Illuminate\Database\Eloquent\Collection|mixed $orderProducts
 */
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    public const FROM_CSP = 'csp';
    public const FROM_ERP = 'erp';

    public const PAYMENT_METHOD_CARD = 'tarjeta';
    public const PAYMENT_METHOD_CASH = 'efectivo';

    public const STATUS_WAITING = 0;
    public const STATUS_FINISHED = 1;
    public const STATUS_CANCELLED = 2;

    protected $fillable = [
        'employee_id',
        'customer_name',
        'total',
        'tax',
        'payment_method',
        'payment_folio',
        'cancel_reason',
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
            if ($estimatedTime >= 15)
                return 15;
        }


        return $estimatedTime;
    }

    public static function calculateTotalRevenue(): float
    {
        $total = 0;

        foreach (self::all() as $order) {
            $total += $order->total;
        }

        return $total;
    }

    public static function totalRevenueChartByMonth(): array
    {
        return Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->values()
            ->toArray();
    }

    public static function calculateLastMonthRevenue(): float
    {
        return self::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
    }

    public static function monthRevenueChartByMonth(): array
    {
        return self::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as day, SUM(total) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->values()
            ->toArray();
    }

    public static function calculateTotalRevenueThisWeek(): float
    {
        return self::query()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total');
    }

    public static function totalRevenueChartByWeek(): array
    {
        return self::query()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as day, SUM(total) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->values()
            ->toArray();
    }

    public static function calculateTotalRevenueToday(): float
    {
        return self::query()
            ->whereDate('created_at', now()->toDateString())
            ->sum('total');
    }

    public static function totalRevenueChartByDay(): array
    {
        return self::query()
            ->whereDate('created_at', now()->toDateString())
            ->selectRaw('HOUR(created_at) as hour, SUM(total) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total', 'hour')
            ->values()
            ->toArray();
    }

    public static function isCurrentMonthRevenueGreaterThanLastMonth(): bool
    {
        $currentMonthRevenue = self::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $lastMonth = now()->subMonth();

        $lastMonthRevenue = self::query()
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total');

        return $currentMonthRevenue >= $lastMonthRevenue;
    }

    public static function isTodayRevenueGreaterThanYesterday(): bool
    {
        $todayRevenue = self::query()
            ->whereDate('created_at', now()->toDateString())
            ->sum('total');

        $yesterdayRevenue = self::query()
            ->whereDate('created_at', now()->subDay()->toDateString())
            ->sum('total');

        return $todayRevenue >= $yesterdayRevenue;
    }

    public static function isThisWeekRevenueGreaterThanLastWeek(): bool
    {
        $thisWeekRevenue = self::query()
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total');

        $lastWeekStart = now()->subWeek()->startOfWeek();
        $lastWeekEnd = now()->subWeek()->endOfWeek();

        $lastWeekRevenue = self::query()
            ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
            ->sum('total');

        return $thisWeekRevenue >= $lastWeekRevenue;
    }

    public static function totalOrdersByMonth(): array
    {
        return self::query()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_orders')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total_orders', 'month')
            ->toArray();
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
