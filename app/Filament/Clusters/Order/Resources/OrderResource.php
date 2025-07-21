<?php

namespace App\Filament\Clusters\Order\Resources;

use App\Filament\Clusters\Order as OrderCluster;
use App\Filament\Clusters\Order\Resources\OrderResource\Pages;
use App\Helpers\Money;
use App\Models\CustomizationOption;
use App\Models\Employee;
use App\Models\MenuProduct;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-2-stack';

//    protected static ?string $cluster = OrderCluster::class;

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    //region Label methods
    public static function getNavigationLabel(): string
    {
        return __("order.model");
    }

    public static function getModelLabel(): string
    {
        return __("order.order");
    }

    public static function getPluralModelLabel(): string
    {
        return __("order.model");
    }

    //endregion

    //region Table methods
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns(self::tableColumns())
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make('view')
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    /**
     * Table columns
     * @return array
     * @author Angel Mendoza
     */
    protected static function tableColumns(): array
    {
        return [
            TextColumn::make("id")
                ->label(__("order.fields.id"))
                ->sortable()
                ->searchable()
                ->prefix("#"),
            TextColumn::make("customer_name")
                ->label(__("order.fields.customer_name"))
                ->searchable()
                ->sortable(),
            TextColumn::make("total")
                ->label(__("order.fields.total"))
                ->sortable()
                ->getStateUsing(fn(Order $order): string => Money::format($order->total)),
            TextColumn::make("from")
                ->label(__("order.fields.from"))
                ->searchable()
                ->sortable()
                ->badge()
                ->getStateUsing(fn(Order $order): string => match ($order->from) {
                    "erp" => __("order.erp"),
                    "csp" => __("order.csp"),
                })
                ->color(fn(string $state): string => match ($state) {
                    __("order.csp") => 'primary',
                    __("order.erp") => 'gray',
                }),
            TextColumn::make("status")
                ->label(__("order.fields.status.label"))
                ->sortable()
                ->badge()
                ->getStateUsing(fn(Order $order): string => match ($order->status) {
                    0 => __("order.fields.status.0"),
                    1 => __("order.fields.status.1"),
                    2 => __("order.fields.status.2"),
                })
                ->color(fn(string $state): string => match ($state) {
                    __("order.fields.status.0") => 'gray',
                    __("order.fields.status.1") => 'success',
                    __("order.fields.status.2") => 'danger',
                }),
            TextColumn::make("created_at")
                ->label(__("order.fields.created_at"))
                ->dateTime()
                ->sortable(),

        ];
    }
    //endregion

    //region Form Methods

    /**
     * Form methods and structure
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::formFields());
    }

    /**
     * Declare form fields
     * @return array
     */
    protected static function formFields(): array
    {
        return [
            Wizard::make([
                self::productStep(),
                self::paymentStep()
            ])
                ->columnSpan("full")
                ->submitAction(new HtmlString(Blade::render(<<<BLADE
                        <x-filament::button
                            type="submit"
                            size="lg"
                        >
                            @lang("order.actions.create")
                        </x-filament::button>
                    BLADE
                ))),
        ];
    }

    /**
     * Wizard step for select products and customizations
     * @return Wizard\Step
     * @author Angel Mendoza
     */
    private static function productStep(): Wizard\Step
    {
        return
            Wizard\Step::make(__("order.select_products"))
                ->icon('heroicon-o-shopping-cart')
                ->description(__("order.select_products_description"))
                ->columns(12)
                ->schema([
                    Repeater::make("")
                        ->statePath("products")
                        ->collapsible()
                        ->defaultItems(1)
                        ->columnSpan(12)
                        ->cloneable()
                        ->schema([
                            Select::make('product_id')
                                ->label(__('order.fields.product_id'))
                                ->columnSpan(11)
                                ->native(false)
                                ->searchable()
                                ->required()
                                ->options(MenuProduct::getAvailableGroupedByCategory())
                                ->reactive()
                                ->live(),
                            self::getProductCustomizationsFields()
                        ])
                ])
                // Set total and tax after product setting
                ->afterValidation(function (Forms\Get $get, Forms\Set $set) {
                    $data = Pages\CreateOrder::cleanData($get("products"));
                    $total = Pages\CreateOrder::calculateTotal($data);

                    $set("total", $total);
                    $set("tax", Pages\CreateOrder::calculateTax($total));
                });
    }

    /**
     * Generate dynamic fields for product customizations
     * @return Forms\Components\Group
     * @author Angel Mendoza
     */
    private static function getProductCustomizationsFields(): Forms\Components\Group
    {
        return Forms\Components\Group::make()
            ->columns(2)
            ->columnSpan(12)
            ->schema(function (callable $get) {
                $requiredFields = [];
                $optionalFields = [];
                $customizations = CustomizationOption::all();

                // Validations
                $productId = $get('product_id');
                if (!$productId) {
                    //! Necessary to create all customization inputs for Filament, if they are not rendered, we can't handle the dynamic fields
                    return $customizations
                        ->groupBy('customization_id')
                        ->map(function ($options) {
                            $customization = $options->first()->customization;

                            return Forms\Components\Placeholder::make("customizations.{$customization->id}")
                                ->visible(false);
                        })
                        ->values() // para quitar las keys del groupBy
                        ->toArray();
                }
                // Load customizations
                $product = MenuProduct::with('customizations')->find($productId);

                // Generate fields
                foreach ($product->customizations as $customization) {
                    if ($customization->required) {
                        $requiredFields[] =
                            Select::make("customizations.{$customization->id}")
                                ->label($customization->name)
                                ->required($customization->required)
                                ->native(false)
                                ->options(
                                // Show option the name and contact the extra price
                                    $customization->options->mapWithKeys(function ($option) {
                                        return [
                                            $option->id => $option->name . ' (+' . Money::format($option->extra_price) . ')'
                                        ];
                                    })->toArray()
                                );
                    } else {
                        $optionalFields[] =
                            Select::make("customizations.{$customization->id}")
                                ->label($customization->name)
                                ->native(false)
                                ->options(
                                // Show option the name and contact the extra price
                                    $customization->options->mapWithKeys(function ($option) {
                                        return [
                                            $option->id => $option->name . ' (+' . Money::format($option->extra_price) . ')'
                                        ];
                                    })->toArray()
                                )
                                ->live()
                                ->multiple();
                    }
                }

                return [
                    Forms\Components\Section::make(__("order.required_customizations"))
                        ->columnSpan(1)
                        ->collapsible(true)
                        ->schema($requiredFields),
                    Forms\Components\Section::make(__("order.optional_customizations"))
                        ->columnSpan(1)
                        ->collapsible(true)
                        ->schema($optionalFields),
                    Forms\Components\Textarea::make('notes')
                        ->label(__("order.fields.notes"))
                        ->columnSpanFull()
                ];
            });
    }

    /**
     * Wizard step to set customer data and payment info
     * @return Wizard\Step
     * @author Angel Mendoza
     */
    private static function paymentStep(): Wizard\Step
    {
        return Wizard\Step::make(__("order.payment"))
            ->icon('heroicon-o-banknotes')
            ->description(__("order.payment_description"))
            ->columns(12)
            ->schema([
                Select::make('employee_id')
                    ->label(__("order.fields.employee_id"))
                    ->columnSpan(12)
                    ->native(false)
                    ->options(Employee::all()->mapWithKeys(function ($employee) {
                        return [
                            $employee->id => $employee->name . ' ' . $employee->last_name
                        ];
                    }))
                    ->default(auth()->user()->employee->id)
                    ->searchable()
                    ->visible(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('manager'))
                    ->required(),
                Forms\Components\TextInput::make('customer_name')
                    ->label(__("order.fields.customer_name"))
                    ->columnSpan(12)
                    ->required(),
                Select::make('payment_method')
                    ->label(__("order.fields.payment_method"))
                    ->columnSpan(12)
                    ->native(false)
                    ->options([
                        "Tarjeta" => "Tarjeta",
                        "Efectivo" => "Efectivo",
                    ])
                    ->required()
                    ->reactive()
                    ->live(),
                Forms\Components\TextInput::make('total')
                    ->label(__("order.fields.total"))
                    ->columnSpan(6)
                    ->prefix("$")
                    ->readOnly(),
                Forms\Components\TextInput::make('tax')
                    ->label(__("order.fields.tax"))
                    ->columnSpan(6)
                    ->prefix("$")
                    ->readOnly(),
            ]);
    }

    //endregion

}
