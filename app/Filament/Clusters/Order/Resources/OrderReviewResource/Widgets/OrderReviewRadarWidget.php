<?php

namespace App\Filament\Clusters\Order\Resources\OrderReviewResource\Widgets;

use App\Models\OrderReview;
use Filament\Widgets\ChartWidget;

class OrderReviewRadarWidget extends ChartWidget
{
    protected static ?string $heading = 'Radar';

    protected function getData(): array
    {
        return [
            'labels' => [__("orderreview.positive"), __("orderreview.neutral"), __("orderreview.negative")],
            'datasets' => [
                [
                    'label' => __("orderreview.model"),
                    'data' => [
                        OrderReview::where('rating', '>', OrderReview::RATING_MEDIUM_MAX)->count(),
                        OrderReview::whereBetween('rating', [OrderReview::RATING_BAD_MAX + 1, OrderReview::RATING_MEDIUM_MAX])->count(),
                        OrderReview::where('rating', '<=', OrderReview::RATING_BAD_MAX)->count(),
                    ],
                    'backgroundColor' => 'rgba(105, 138, 95, 0.25)',
                    'borderColor' => '#698a5f',
                    'pointBackgroundColor' => '#698a5f',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => '#698a5f',
                    'fill' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
