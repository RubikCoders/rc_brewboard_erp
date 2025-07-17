<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Helpers\Money;
use App\Models\Order;
use App\Models\OrderProduct;
use Filament\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\HtmlString;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function form(Form $form): Form
    {
        if (!empty($this->record->orderProducts)) {
            $orderProducts = $this->record->orderProducts;
        }


        return $form
            ->schema([
                ...self::orderInputs(),
                Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 3,
                    'xl' => 3,
                ])->schema(self::productsInputs())
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            self::deliverOrder(),
            self::cancelOrder(),
        ];
    }

    /**
     * Order info inputs
     * @return array
     */
    public function orderInputs(): array
    {
        return [
            Section::make(__("order.payment_label"))
                ->collapsible()
                ->collapsed()
                ->columns(12)
                ->schema([
                    Placeholder::make('employee')
                        ->label(__("order.fields.employee_id"))
                        ->columnSpan(3)
                        ->visible(auth()->user()->hasRole('super_admin'))
                        ->content($this->record->employee->name . ' ' . $this->record->employee->last_name),
                    Placeholder::make('payment_method')
                        ->label(__("order.fields.payment_method"))
                        ->columnSpan(3)
                        ->content($this->record->payment_method),
                    Placeholder::make('tax')
                        ->label(__("order.fields.total"))
                        ->columnSpan(3)
                        ->content(Money::format($this->record->total)),
                    Placeholder::make('tax')
                        ->label(__("order.fields.tax"))
                        ->columnSpan(3)
                        ->content(Money::format($this->record->tax)),
                ]),
            Section::make(__("order.order"))
                ->columns(12)
                ->collapsible()
                ->schema([
                    Placeholder::make('id')
                        ->label(__("order.fields.id"))
                        ->columnSpan(3)
                        ->content('#' . $this->record->id),
                    Placeholder::make('customer_name')
                        ->label(__("order.fields.customer_name"))
                        ->columnSpan(3)
                        ->content($this->record->customer_name),
                    Placeholder::make('from')
                        ->label(__("order.taken_in"))
                        ->columnSpan(3)
                        ->content(fn() => match ($this->record->from) {
                            "erp" => __("order.erp"),
                            "csp" => __("order.csp"),
                        }),
                    Placeholder::make('status')
                        ->label(__("order.fields.status.label"))
                        ->columnSpan(3)
                        ->content(function (): HtmlString {
                            return new HtmlString(match ($this->record->status) {
                                Order::STATUS_WAITING => "<span style='color: gray; background-color: rgba(213,213,213,0.29); border: 1px solid gray; border-radius: 10px; padding: 5px'>" . __("order.fields.status.0") . "</span>",
                                Order::STATUS_FINISHED => "<span style='color: #5F7C56; background-color: rgba(152,188,141,0.28); border: 1px solid #5F7C56; border-radius: 10px; padding: 5px'>" . __("order.fields.status.1") . "</span>",
                                Order::STATUS_CANCELLED => "<span style='color: #d34f4f; background-color: rgba(255,176,176,0.4); border: 1px solid #d34f4f; border-radius: 10px; padding: 5px'>" . __("order.fields.status.2") . "</span>",
                            });
                        })
                ])
        ];
    }

    /**
     * List of products
     * @return array
     */
    public function productsInputs(): array
    {
        $products = $this->record->orderProducts;
        $fields = [];

        foreach ($products as $orderProduct) {
            $title = $orderProduct->quantity != 1 ? $orderProduct->product->name . ' x' . $orderProduct->quantity : $orderProduct->product->name;

            $status = new HtmlString(match ($orderProduct->kitchen_status) {
                default => "",
                OrderProduct::KITCHEN_STATUS_IN_PROGRESS => "<span style='color: gray; background-color: rgba(213,213,213,0.29); border: 1px solid gray; border-radius: 10px; margin-left: 10px; padding: 5px'>" . __("order.fields.kitchen_status.0") . "</span>",
                OrderProduct::KITCHEN_STATUS_READY => "<span style='color: #5F7C56; background-color: rgba(152,188,141,0.28); border: 1px solid #5F7C56; border-radius: 10px;margin-left: 10px; padding: 5px'>" . __("order.fields.kitchen_status.1") . "</span>",
                OrderProduct::KITCHEN_STATUS_DELIVERED => "<span style='color: #2c96e1; background-color: rgba(135,199,244,0.27); border: 1px solid #2c96e1; border-radius: 10px;margin-left: 10px; padding: 5px'>" . __("order.fields.kitchen_status.2") . "</span>",
            });

            $fields[] = Section::make(new HtmlString($title . $status))
                ->columnSpan(1)
                ->collapsible()
                ->schema([
                    Placeholder::make('description')
                        ->label(__("order.fields.description"))
                        ->content($orderProduct->product->description),
                    Placeholder::make('notes')
                        ->label(__("order.fields.notes"))
                        ->content($orderProduct->notes ?? '-'),
                    \Filament\Forms\Components\Actions::make([
                        Action::make('status_ready')
                            ->label(__("order.actions.status_ready"))
                            ->requiresConfirmation()
                            ->color('gray')
                            ->visible($orderProduct->kitchen_status == OrderProduct::KITCHEN_STATUS_IN_PROGRESS && $this->record->status != Order::STATUS_CANCELLED)
                            ->action(function () use ($orderProduct) {
                                $orderProduct->update([
                                    'kitchen_status' => OrderProduct::KITCHEN_STATUS_READY
                                ]);
                            }),
                        Action::make('status_delivered')
                            ->label(__("order.actions.status_delivered"))
                            ->requiresConfirmation()
                            ->visible($orderProduct->kitchen_status == OrderProduct::KITCHEN_STATUS_READY && $this->record->status != Order::STATUS_CANCELLED)
                            ->color('primary')
                            ->action(function () use ($orderProduct) {
                                $orderProduct->update([
                                    'kitchen_status' => OrderProduct::KITCHEN_STATUS_DELIVERED
                                ]);
                            }),
                    ])
                ]);
        }

        return $fields;
    }

    private function deliverOrder(): Actions\Action
    {
        return Actions\Action::make('order_delivered')
            ->label(__("order.actions.order_delivered"))
            ->requiresConfirmation()
            ->size('xl')
            ->visible($this->record->status == Order::STATUS_WAITING)
            ->action(function () {
                if (!Order::allProductsDelivered($this->record)) {
                    Notification::make('no_products_delivered')
                        ->danger()
                        ->title(__("order.notification.no_products_delivered.title"))
                        ->body(__("order.notification.no_products_delivered.body"))
                        ->send();

                    return;
                }

                $this->record->update([
                    'status' => Order::STATUS_FINISHED
                ]);
            });
    }

    private function cancelOrder(): Actions\Action
    {
        return Actions\Action::make('order_canceled')
            ->label(__("order.actions.order_canceled"))
            ->requiresConfirmation()
            ->size('xl')
            ->color('danger')
            ->visible($this->record->status == Order::STATUS_WAITING)
            ->action(function () {
                $this->record->update([
                    'status' => Order::STATUS_CANCELLED
                ]);
            });
    }
}
