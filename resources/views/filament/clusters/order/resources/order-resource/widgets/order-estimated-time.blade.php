@php
    use App\Models\Order;
@endphp

<x-filament-widgets::widget class="widget-container">
    <div class="container">
        <div class="order-card"
        >
            <div class="order-body">
                <div>
                    {{-- Tiempo estimado --}}
                    <p class="font-semibold">
                        @lang('baristaview.estimated_time')<br>
                        <span class="font-normal time">
                            @lang('baristaview.estimated_time_value', ['number' => $order->estimated_time])
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>


        .container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .order-card {
            width: 100%;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .order-body {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .time {
            font-size: 1.3rem;
            font-weight: 600;
        }

    </style>
</x-filament-widgets::widget>
