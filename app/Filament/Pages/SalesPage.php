<?php

namespace App\Filament\Pages;

use App\Helpers\Formatter;
use App\Helpers\Money;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class SalesPage extends Page implements HasTable
{
    use InteractsWithTable, HasPageShield;
    protected static ?int $navigationSort = 100;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static string $view = 'filament.pages.sales-page';

    public static function getNavigationLabel(): string
    {
        return __("sales.title");
    }

    public function getTitle(): string
    {
        return __("sales.title");
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make("report")
                ->label(__("sales.actions.report"))
                ->modalDescription(__("sales.report_description"))
                ->tooltip(__("sales.tooltips.report"))
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->modalWidth('md')
                ->modalSubmitActionLabel("Generar")
                ->form([
                    Placeholder::make('separator')
                        ->label("")
                        ->content(new HtmlString("<hr>")),
                    Checkbox::make('allSales')
                        ->label(__("sales.fields.all_sales"))
                        ->default(false)
                        ->live(),
                    DatePicker::make('start_date')
                        ->label(__("sales.fields.start_date"))
                        ->closeOnDateSelection()
                        ->native(false)
                        ->required(fn(Get $get): bool => !$get("allSales") ?? false)
                        ->placeholder("dic 26. 2023")
                        ->hidden(fn(Get $get): bool => $get("allSales") ?? false),
                    DatePicker::make('end_date')
                        ->label(__("sales.fields.end_date"))
                        ->placeholder("dic 26. 2025")
                        ->native(false)
                        ->closeOnDateSelection()
                        ->maxDate(now())
                        ->default(now())
                        ->required(fn(Get $get): bool => !$get("allSales") ?? false)
                        ->hidden(fn(Get $get): bool => $get("allSales") ?? false),
                    Select::make('payment_method')
                        ->label(__('Método de pago'))
                        ->multiple()
                        ->options([
                            Order::PAYMENT_METHOD_CARD => __('order.filters.payment_card'),
                            Order::PAYMENT_METHOD_CASH => __('order.filters.payment_cash'),
                        ]),
                    Select::make('from')
                        ->label(__('De'))
                        ->multiple()
                        ->options([
                            Order::FROM_ERP => "Caja",
                            Order::FROM_CSP => "Kiosko",
                        ])
                ])
                ->action(function (array $data) {
                    return self::downloadReportPdf(
                        $data['allSales'],
                        $data['start_date'] ?? null,
                        $data['end_date'] ?? null,
                        $data['payment_method'] ?? [],
                        $data['from'] ?? []
                    );
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->where("status", Order::STATUS_FINISHED))
            ->columns(self::tableColumns())
            ->filters(self::tableFilters());
    }

    private static function tableColumns(): array
    {
        return [
            TextColumn::make("id")
                ->label(__("sales.fields.order_id"))
                ->sortable()
                ->searchable()
                ->prefix("#"),
            TextColumn::make("employee.name")
                ->label(__("sales.fields.employee_id"))
                ->getStateUsing(fn(Order $order): string => $order->employee->name . " " . $order->employee->last_name)
                ->searchable()
                ->sortable(),
            TextColumn::make("total")
                ->label(__("sales.fields.total"))
                ->sortable()
                ->getStateUsing(fn(Order $order): string => Money::format($order->total)),
            TextColumn::make("tax")
                ->label(__("sales.fields.tax"))
                ->sortable()
                ->getStateUsing(fn(Order $order): string => Money::format($order->tax)),
            TextColumn::make("payment_method")
                ->label(__("sales.fields.payment_method"))
                ->sortable()
                ->getStateUsing(fn(Order $order): string => ucfirst($order->payment_method))
                ->searchable(),
            TextColumn::make("from")
                ->label(__("sales.fields.from"))
                ->searchable()
                ->sortable()
                ->badge()
                ->getStateUsing(fn(Order $order): string => match ($order->from) {
                    "erp" => __("order.erp"),
                    "csp" => __("order.csp"),
                    default => $order->from,
                })
                ->color(fn(string $state): string => match ($state) {
                    __("order.csp") => 'primary',
                    __("order.erp") => 'gray',
                    default => 'secondary',
                }),
            TextColumn::make("created_at")
                ->label(__("sales.fields.created_at"))
                ->sortable()
                ->searchable()
                ->dateTime(),
        ];
    }

    private static function tableFilters(): array
    {
        return [
            SelectFilter::make('payment_method')
                ->label(__('Método de pago'))
                ->multiple()
                ->options([
                    Order::PAYMENT_METHOD_CARD => __('order.filters.payment_card'),
                    Order::PAYMENT_METHOD_CASH => __('order.filters.payment_cash'),
                ]),
            SelectFilter::make('from')
                ->label(__('De'))
                ->multiple()
                ->options([
                    Order::FROM_ERP => "Caja",
                    Order::FROM_CSP => "Kiosko",
                ]),
        ];
    }

    /**
     * Generate sales report pdf applying all filters
     *
     * @param bool $allSales
     * @param string|null $startDate
     * @param string|null $endDate
     * @param array $paymentMethods
     * @param array $froms
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private static function downloadReportPdf(
        bool $allSales,
        ?string $startDate,
        ?string $endDate,
        array $paymentMethods = [],
        array $froms = []
    ) {
        ini_set('memory_limit', '512M');
        set_time_limit(60);

        $query = Order::query()
            ->where('status', Order::STATUS_FINISHED);

        if (!$allSales && $startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        if (!empty($paymentMethods)) {
            $query->whereIn('payment_method', $paymentMethods);
        }

        if (!empty($froms)) {
            $query->whereIn('from', $froms);
        }

        $orders = $query->get();

        $generatedAt = Formatter::dateTime(Carbon::now());
        $generatedBy = Auth::user()?->name ?? __("sales.system");

        $dateRange = $allSales
            ? __("sales.all_sales")
            : Formatter::date($startDate) . " " . __("sales.to") . " " . Formatter::date($endDate);

        $total = Money::format($orders->sum('total'));
        $averageTicket = Money::format($orders->avg('total'));

        foreach ($orders as $order) {
            $order->from = match ($order->from) {
                "erp" => __("order.erp"),
                "csp" => __("order.csp"),
                default => $order->from,
            };

            $order->total = Money::format($order->total);
            $order->tax = Money::format($order->tax);
        }

        $pdf = Pdf::loadView('pdf.sales-report', [
            'generatedAt' => $generatedAt,
            'dateRange' => $dateRange,
            'generatedBy' => $generatedBy,
            'orders' => $orders,
            'total' => $total,
            'averageTicket' => $averageTicket,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $filename = 'reporte-ventas-' . now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
}
