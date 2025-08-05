<?php

namespace App\Filament\Clusters\Order\Resources\OrderReviewResource\Widgets;

use App\Models\OrderReview;
use Filament\Widgets\ChartWidget;

class OrderReviewPieWidget extends ChartWidget
{
    protected static ?string $heading = 'Porcentaje de Reseñas';

    protected function getData(): array
    {
        $total = OrderReview::count();

        $positive = OrderReview::where('rating', '>', OrderReview::RATING_MEDIUM_MAX)->count() / $total * 100;
        $neutral = OrderReview::whereBetween('rating', [OrderReview::RATING_BAD_MAX + 1, OrderReview::RATING_MEDIUM_MAX])->count() / $total * 100;
        $negative = OrderReview::where('rating', '<=', OrderReview::RATING_BAD_MAX)->count() / $total * 100;


        return [
            'datasets' => [
                [
                    'label' => 'Reseñas',
                    'data' => [$positive, $neutral, $negative],
                    'backgroundColor' => ['#0BBA4E', '#F7CF67', '#d68787'], // Verde, Amarillo, Rojo
                ],
            ],
            'labels' => ['Positivas', 'Neutrales', 'Negativas'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
