<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\OrderReview;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class ReviewsChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?int $sort = 3;

    public function getHeading(): string|Htmlable|null
    {
        $avg = number_format(OrderReview::avg('rating'), 1);
        $starsOutOfFive = $avg / 2;

        $fullStars = floor($starsOutOfFive);
        $halfStar = ($starsOutOfFive - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        $starsHtml = str_repeat('★', $fullStars);
        $starsHtml .= $halfStar ? '⯨' : ''; // Usa otro emoji si prefieres
        $starsHtml .= str_repeat('☆', $emptyStars);

        return new HtmlString("Reseñas - $avg <span style='font-size: 1rem; color: #facc15;'>$starsHtml</span>");
    }

    protected function getData(): array
    {
        Carbon::setLocale('es');

        $labels = [];
        $negativas = [];
        $neutrales = [];
        $positivas = [];

        // Recorremos los últimos 12 meses
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->startOfMonth();

            // Etiqueta: nombre corto del mes, capitalizado (Ej: Ago, Sep)
            $labels[] = ucfirst($month->translatedFormat('M'));

            // Filtrar reseñas de ese mes
            $reviews = OrderReview::query()
                ->whereBetween('created_at', [$month, $month->copy()->endOfMonth()]);

            $negativas[] = (clone $reviews)->where('rating', '<=', OrderReview::RATING_BAD_MAX)->count();
            $neutrales[] = (clone $reviews)->whereBetween('rating', [OrderReview::RATING_BAD_MAX + 1, OrderReview::RATING_MEDIUM_MAX])->count();
            $positivas[] = (clone $reviews)->where('rating', '>', OrderReview::RATING_MEDIUM_MAX)->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Negativas',
                    'data' => $negativas,
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
                ],
                [
                    'label' => 'Neutrales',
                    'data' => $neutrales,
                    'borderColor' => 'rgba(255, 205, 86, 1)',
                    'backgroundColor' => 'rgba(255, 205, 86, 0.5)',
                ],
                [
                    'label' => 'Positivas',
                    'data' => $positivas,
                    'borderColor' => 'rgb(75, 192, 124)',
                    'backgroundColor' => 'rgba(75, 192, 120, 0.5)',
                ],
            ]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

}
