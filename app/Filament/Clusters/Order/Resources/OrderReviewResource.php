<?php

namespace App\Filament\Clusters\Order\Resources;

use App\Filament\Clusters\Order;
use App\Filament\Clusters\Order\Resources\OrderReviewResource\Pages;

use App\Models\OrderReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class OrderReviewResource extends Resource
{
    protected static ?string $model = OrderReview::class;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $cluster = Order::class;

    public static function canCreate(): bool
    {
        return false;
    }

    //region Label methods
    public static function getNavigationLabel(): string
    {
        return __("orderreview.model");
    }

    public static function getModelLabel(): string
    {
        return __("orderreview.order");
    }

    public static function getPluralModelLabel(): string
    {
        return __("orderreview.model");
    }

    //endregion

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns(self::tableColumns())
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make("view")
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderReviews::route('/'),
            'view' => Pages\ViewOrderReview::route("/view/{record}")
        ];
    }

    //region Table methods
    public static function tableColumns(): array
    {
        return [
            TextColumn::make('image')
                ->label(__("orderreview.fields.photo"))
                ->getStateUsing(function (OrderReview $record) {
                    $url = route('private.image', ['path' => $record->image_path ?? OrderReview::PLACEHOLDER_IMAGE]);

                    return new HtmlString("
                    <div style='
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        overflow: hidden;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    '>
                        <img src='$url' style='
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        ' />
                    </div>
                ");

                }),
            TextColumn::make("order.customer_name")
                ->label(__("orderreview.fields.customer_name"))
                ->placeholder("-"),
            TextColumn::make('rating')
                ->label(__("orderreview.fields.rating"))
                ->sortable()
                ->suffix(" / " . OrderReview::RATING_MAX)
                ->color(fn($state) => match (true) {
                    $state <= OrderReview::RATING_BAD_MAX => 'danger',
                    $state <= OrderReview::RATING_MEDIUM_MAX => 'warning',
                    default => 'success',
                })
                ->weight("bold"),
            TextColumn::make('comment')
                ->label(__("orderreview.fields.comment"))
                ->placeholder('-')
                ->sortable()
                ->words(15)
                ->limit(20),
            TextColumn::make('created_at')
                ->label(__("orderreview.fields.created_at"))
                ->dateTime()
        ];
    }
    //endregion

}
