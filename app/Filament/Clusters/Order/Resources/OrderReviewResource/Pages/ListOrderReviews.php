<?php

namespace App\Filament\Clusters\Order\Resources\OrderReviewResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderReviewResource;
use App\Filament\Clusters\Order\Resources\OrderReviewResource\Widgets\OrderReviewPieWidget;
use App\Filament\Clusters\Order\Resources\OrderReviewResource\Widgets\OrderReviewRadarWidget;
use App\Filament\Clusters\Order\Resources\OrderReviewResource\Widgets\OrderReviewWidget;
use App\Models\OrderReview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
class ListOrderReviews extends ListRecords
{
    protected static string $resource = OrderReviewResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            OrderReviewWidget::make()
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__("order.tabs.all"))
                ->icon('heroicon-o-squares-2x2')
                ->badge(OrderReview::count()),

            'positive' => Tab::make(__("orderreview.tabs.positive"))
                ->icon('heroicon-o-hand-thumb-up')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('rating', '>', OrderReview::RATING_MEDIUM_MAX))
                ->badge(OrderReview::where('rating', '>', OrderReview::RATING_MEDIUM_MAX)->count())
                ->badgeColor('success'),

            'neutral' => Tab::make(__("orderreview.tabs.neutral"))
                ->icon('heroicon-o-equals')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->whereBetween('rating', [
                        OrderReview::RATING_BAD_MAX + 1,
                        OrderReview::RATING_MEDIUM_MAX
                    ])
                )
                ->badge(OrderReview::whereBetween('rating', [
                    OrderReview::RATING_BAD_MAX + 1,
                    OrderReview::RATING_MEDIUM_MAX
                ])->count())
                ->badgeColor('warning'),

            'negative' => Tab::make(__("orderreview.tabs.negative"))
                ->icon('heroicon-o-hand-thumb-down')
                ->modifyQueryUsing(
                    fn(Builder $query) =>
                    $query->where('rating', '<=', OrderReview::RATING_BAD_MAX)
                )
                ->badge(OrderReview::where('rating', '<=', OrderReview::RATING_BAD_MAX)->count())
                ->badgeColor('danger'),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            OrderReviewRadarWidget::make(),
            OrderReviewPieWidget::make()
        ];
    }
}
