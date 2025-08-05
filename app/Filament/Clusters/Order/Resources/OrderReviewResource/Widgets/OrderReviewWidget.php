<?php

namespace App\Filament\Clusters\Order\Resources\OrderReviewResource\Widgets;

use App\Filament\Clusters\Order\Resources\OrderReviewResource\Pages\ListOrderReviews;
use App\Models\OrderReview;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderReviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                __("orderreview.widgets.average.label"),
                number_format(OrderReview::avg('rating'), 1)
            )
                ->description(__('orderreview.widgets.average.description'))
                ->descriptionIcon('heroicon-o-star')
                ->color('info')
                ->chart([10, 10]) // opcional, puedes actualizar con datos reales si gustas
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            // Positive
            Stat::make(
                __("orderreview.widgets.positive.label"),
                OrderReview::where('rating', '>', OrderReview::RATING_MEDIUM_MAX)
                    ->count()
            )
                ->description(__('orderreview.widgets.positive.description'))
                ->descriptionIcon('heroicon-o-hand-thumb-up')
                ->color('success')
                ->chart(OrderReview::getPositiveReviewsSimpleChart())
                ->url(ListOrderReviews::getUrl([
                    'activeTab' => 'positive',
                ]))
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            // neutral
            Stat::make(
                __("orderreview.widgets.neutral.label"),
                OrderReview::whereBetween('rating', [
                    OrderReview::RATING_BAD_MAX + 1,
                    OrderReview::RATING_MEDIUM_MAX,
                ])->count()
            )
                ->description(__('orderreview.widgets.neutral.description'))
                ->descriptionIcon('heroicon-o-equals')
                ->color('warning')
                ->chart(OrderReview::getNeutralReviewsSimpleChart())
                ->url(ListOrderReviews::getUrl([
                    'activeTab' => 'neutral',
                ]))
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

            // Negative
            Stat::make(
                __("orderreview.widgets.negative.label"),
                OrderReview::where('rating', '<=', OrderReview::RATING_BAD_MAX)->count()
            )
                ->description(__('orderreview.widgets.negative.description'))
                ->descriptionIcon('heroicon-o-hand-thumb-down')
                ->color('danger')
                ->chart(OrderReview::getNegativeReviewsSimpleChart())
                ->url(ListOrderReviews::getUrl([
                    'activeTab' => 'negative',
                ]))
                ->extraAttributes([
                    'class' => 'cursor-pointer [&_.fi-stat-value]:text-3xl [&_.fi-stat-value]:font-bold [&_.fi-stat-value]:text-center',
                ]),

        ];
    }
}
