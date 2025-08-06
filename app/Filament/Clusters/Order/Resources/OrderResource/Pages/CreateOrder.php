<?php

namespace App\Filament\Clusters\Order\Resources\OrderResource\Pages;

use App\Filament\Clusters\Order\Resources\OrderResource;
use App\Helpers\Money;
use App\Models\CustomizationOption;
use App\Models\MenuProduct;
use App\Models\Order;
use App\Models\OrderCustomization;
use App\Models\OrderProduct;
use Filament\Resources\Pages\CreateRecord;
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
        $data = self::cleanData($this->form->getState());
        $products = $data['products'];

        // Create Order
        $order = Order::create([
            'employee_id' => $data['employee_id'] ?? null,
            'customer_name' => $data['customer_name'],
            'total' => $data['total'],
            'tax' => $data['tax'],
            'payment_method' => $data['payment_method'],
            'from' => Order::FROM_ERP,
            'status' => Order::STATUS_WAITING,
        ]);

        // Create Order Products
        foreach ($products as $productData) {
            $product = MenuProduct::find($productData['product_id']);

            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productData['product_id'],
                'quantity' => 1, // 1 due filament form logic, if the customer wants another just "clone" in the repeater
                'is_delivered' => false,
                'total_price' => $product->base_price,
                'notes' => $productData['notes'] ?? null,
                'kitchen_status' => OrderProduct::KITCHEN_STATUS_IN_PROGRESS,
            ]);

            // Create Order Customizations
            $customizations = $productData['customizations'];

            foreach ($customizations as $customization) {
                if (is_array($customization)) {
                    foreach ($customization as $sub) {
                        OrderCustomization::create([
                            'order_product_id' => $orderProduct->id,
                            'product_customization_id' => $sub
                        ]);
                    }
                } else {
                    OrderCustomization::create([
                        'order_product_id' => $orderProduct->id,
                        'product_customization_id' => $customization
                    ]);
                }
            }
        }

        $this->getCreatedNotification()?->send();

        $redirectUrl = OrderResource::getUrl('index');

        $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
        return;
    }

    /**
     * Set the notification title
     * @return string|null
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return __("order.notification.create");
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

            if(!array_key_exists('customizations', $product)) return 0;

            // Get customizations and sum every extra price
            foreach ($product['customizations'] as $customization) {
                if (is_array($customization)) {
                    foreach ($customization as $sub) {
                        $total += CustomizationOption::find($sub)->extra_price ?? 0;
                    }
                } else {
                    $total += CustomizationOption::find($customization)->extra_price ?? 0;
                }
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
