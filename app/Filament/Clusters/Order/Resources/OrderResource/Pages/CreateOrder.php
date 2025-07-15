<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Helpers\Money;
use App\Models\CustomizationOption;
use App\Models\MenuProduct;
use App\Models\ProductCustomization;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Facades\FilamentView;
use function Filament\Support\is_app_url;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction(),
        ];
    }

    public function create(bool $another = false): void
    {
        $data = $this->form->getState();

        dd(self::cleanData($data));

//        $this->getCreatedNotification()?->send();

//        $redirectUrl = $this->getRedirectUrl();

//        $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
    }

    /**
     * Clean data form, created because to create dynamic product customization inputs Filament need render all customizations in the repeater, just to save the value in $this->data
     * @param array $data
     * @return array
     * @author Angel Mendoza
     */
    public static function cleanData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Recursive for nesting
                $data[$key] = self::cleanData($value);

                // clear null values or empty arrays
                if (empty($data[$key])) {
                    unset($data[$key]);
                }
            } elseif (is_null($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * Calculate total from form data
     * @param array $data from form
     * @return int
     * @author Angel Mendoza
     */
    public static function calculateTotal(array $data): int
    {
        $total = 0;

        // Get product and sum the base price
        foreach ($data as $product) {
            $total += MenuProduct::find($product['product_id'])->base_price;


            // Get customizations and sum every extra price
            foreach ($product['customizations'] as $customization) {
                $total += CustomizationOption::find($customization)->extra_price;
            }
        }


        return $total;
    }

    /**
     * Calculate tax via total
     * @param int $total
     * @return int
     * @author Angel Mendoza
     */
    public static function calculateTax(int $total): int
    {
        return $total * Money::IVA;
    }
}
