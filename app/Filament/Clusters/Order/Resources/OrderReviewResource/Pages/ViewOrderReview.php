<?php

namespace App\Filament\Clusters\Order\Resources\OrderReviewResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Filament\Clusters\Order\Resources\OrderReviewResource;
use App\Helpers\Formatter;
use App\Models\OrderReview;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class ViewOrderReview extends ViewRecord
{
    protected static string $resource = OrderReviewResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    self::pictureSection(),
                    self::orderSection(),
                ])
                    ->from("lg")
                    ->columnSpanFull()
            ]);
    }

    private function pictureSection(): Section
    {
        return Section::make("")
            ->schema([
                Placeholder::make("image")
                    ->label("")
                    ->content(function () {
                        $base64 = base64_encode(Storage::disk('private_reviews')->get(OrderReview::PLACEHOLDER_IMAGE));

                        if ($this->record->image_path) {
                            $base64 = base64_encode(Storage::disk('private_reviews')->get($this->record->image_path));
                        }

                        return new HtmlString("<img src='data:image/jpeg;base64,$base64'></img>");
                    })
            ]);
    }

    private function orderSection(): Grid
    {
        return Grid::make("")
            ->schema([
                Section::make(__("orderreview.order_data"))
                    ->hidden(is_null($this->record->order))
                    ->headerActions([
                        Action::make("view_order")
                            ->label(__("orderreview.actions.view_order"))
                            ->url(OrderResource::getUrl("view", ["record" => $this->record]))
                            ->openUrlInNewTab()
                    ])
                    ->description(function () {
                        if (!is_null($this->record->order) && !is_null($this->record->order->customer_name)) {
                            return __("orderreview.order_data_description", [
                                'name' => $this->record->order->customer_name
                            ]);
                        }

                        return __("orderreview.order_data_description_default");
                    })
                    ->schema([
                        Placeholder::make("order.id")
                            ->label(__("orderreview.fields.order_id_label"))
                            ->content(function () {
                                if (is_null($this->record->order))
                                    return "";
                                return "#" . $this->record->order->id;
                            }),
                        Placeholder::make("order.customer_name")
                            ->label(__("orderreview.fields.customer_name"))
                            ->content(function () {
                                if (is_null($this->record->order))
                                    return "";
                                return $this->record->order->customer_name;
                            }),
                        Placeholder::make("order.created_at")
                            ->label(__("orderreview.fields.order_created_at"))
                            ->content(function () {
                                if (is_null($this->record->order))
                                    return "";
                                return $this->record->order->created_at;
                            }),
                    ]),

                Section::make(__("orderreview.review_data"))
                    ->description(function () {
                        if (!is_null($this->record->order) && !is_null($this->record->order->customer_name)) {
                            return __("orderreview.review_data_description", [
                                'name' => $this->record->order->customer_name
                            ]);
                        }

                        return __("orderreview.review_data_description_default");
                    })
                    ->schema([

                        Placeholder::make('rating_stars')
                            ->label("")
                            ->content(function () {
                                $rating = (float) $this->record->rating;
                                $starsOutOfFive = $rating / 2;

                                $fullStars = floor($starsOutOfFive);
                                $halfStar = ($starsOutOfFive - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                                $starsHtml = str_repeat('★', $fullStars);
                                $starsHtml .= $halfStar ? '⯨' : ''; // Usa otro emoji si prefieres
                                $starsHtml .= str_repeat('☆', $emptyStars);

                                return new HtmlString("<span style='font-size: 1.8rem; color: #facc15;'>$starsHtml</span>");
                            }),
                        Placeholder::make("comment")
                            ->label("")
                            ->content($this->record->comment ?? "-"),
                    ]),
            ]);
    }
}
