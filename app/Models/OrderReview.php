<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderReview extends Model
{
    /** @use HasFactory<\Database\Factories\OrderReviewFactory> */
    use HasFactory;

    //region Attributes
    public const RATING_BAD_MAX = 4;
    public const RATING_MEDIUM_MAX = 7;
    public const RATING_MIN = 0;
    public const RATING_MAX = 10;
    public const PLACEHOLDER_IMAGE = "placeholder.jpg";

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

    //region methods

    /**
     * Calculate good reviews for a month
     * @return array items per day
     */
    public static function getPositiveReviewsSimpleChart()
    {
        $data = OrderReview::select(
            DB::raw("DATE(created_at) as day"),
            DB::raw('COUNT(*) as count')
        )
            ->where('rating', '>', OrderReview::RATING_MEDIUM_MAX)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $counts = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $days[] = $day;
            $counts[] = $data[$day] ?? 0;
        }

        return $counts;
    }

    /**
     * Calculate neutral reviews for a month
     * @return array items per day
     */
    public static function getNeutralReviewsSimpleChart()
    {
        $data = self::select(
            DB::raw("DATE(created_at) as day"),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('rating', [self::RATING_BAD_MAX + 1, self::RATING_MEDIUM_MAX])
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $counts = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $counts[] = $data[$day] ?? 0;
        }

        return $counts;
    }

    /**
     * Calculate bad reviews for a month
     * @return array items per day
     */
    public static function getNegativeReviewsSimpleChart()
    {
        $data = self::select(
            DB::raw("DATE(created_at) as day"),
            DB::raw('COUNT(*) as count')
        )
            ->where('rating', '<=', self::RATING_BAD_MAX)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $counts = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->format('Y-m-d');
            $counts[] = $data[$day] ?? 0;
        }

        return $counts;
    }

    public static function getRatingSummaryChart(): array
    {
        $reviews = self::query();

        return [
            'Positivas' => (clone $reviews)->where('rating', '>', self::RATING_MEDIUM_MAX)->count(),
            'Neutrales' => (clone $reviews)->whereBetween('rating', [self::RATING_BAD_MAX + 1, self::RATING_MEDIUM_MAX])->count(),
            'Negativas' => (clone $reviews)->where('rating', '<=', self::RATING_BAD_MAX)->count(),
        ];
    }
    //endregion
}
