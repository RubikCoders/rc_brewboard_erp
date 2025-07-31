@php
    use App\Models\OrderProduct;
    use App\Models\Order;
@endphp

<x-filament-widgets::widget class="widget-container" wire:poll.5s>
    <div class="container">
        @foreach($orders as $order)
            <div class="order-card"
                 x-data="{
                        createdAt: '{{ $order->created_at->toIso8601String() }}',
                        estimatedMinutes: {{ $order->estimated_time }},
                        timeAgo: 'Calculando tiempo...',
                        elapsedStatus: 'success',
                        intervalSet: false,
                        updateTime() {
                            const now = new Date();
                            const created = new Date(this.createdAt);
                            const seconds = Math.floor((now - created) / 1000);
                            const minutes = seconds / 60;

                            const timeSince = (date) => {
                                const seconds = Math.floor((new Date() - date) / 1000);
                                const intervals = [
                                    { label: 'año', seconds: 31536000 },
                                    { label: 'mes', seconds: 2592000 },
                                    { label: 'día', seconds: 86400 },
                                    { label: 'hora', seconds: 3600 },
                                    { label: 'minuto', seconds: 60 },
                                    { label: 'segundo', seconds: 1 },
                                ];
                                for (const interval of intervals) {
                                    const count = Math.floor(seconds / interval.seconds);
                                    if (count >= 1) {
                                        return `${count} ${interval.label}${count > 1 ? 's' : ''}`;
                                    }
                                }
                                return 'unos segundos';
                            };

                            this.timeAgo = timeSince(created);

                            if (minutes < this.estimatedMinutes * 0.75) {
                                this.elapsedStatus = 'success';
                            } else if (minutes < this.estimatedMinutes) {
                                this.elapsedStatus = 'warning';
                            } else {
                                this.elapsedStatus = 'danger';
                            }
                        }
                    }"
                 x-init="
                        updateTime();
                        if (!intervalSet) {
                            setInterval(() => { updateTime() }, 100);
                            intervalSet = true;
                        }
                    "
            >
                <a href={{\App\Filament\Clusters\Order\Resources\OrderResource::getUrl('view', [
    'record' => $order->id
])}}>
                    <div class="order-header">
                        <div class="order-title">
                            #{{ $order->id }} - {{ $order->customer_name }}
                        </div>

                        <div class="order-from">
                            @if(in_array($order->from, ['erp', 'csp']))
                                <div class="from-{{ $order->from }}">
                                    @lang('order.' . $order->from)
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="order-separator">

                    <div class="order-body">
                        {{-- Products --}}
                        <div>
                            <span class="font-semibold">
                                @lang("baristaview.products")
                            </span>

                            <div class="product-list">
                                <ul>
                                    @foreach($order->orderProducts->unique('product_id') as $orderProduct)
                                        <li class="product-list-item">- {{ $orderProduct->product->name }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>

                        {{-- Times --}}
                        <div class="times">
                            {{-- Since --}}
                            <p class="font-semibold">
                                @lang('baristaview.elapsed_time')<br>

                                <span class="font-normal time {{$order->elapsed_status }}">
                                {{ $order->time_ago }}
                            </span>
                            </p>


                            <hr class="order-separator">

                            <p class="font-semibold"> @lang('baristaview.estimated_time')<br> <span
                                    class="font-normal time"> @lang('baristaview.estimated_time_value', ['number' => $order->estimated_time])</span>
                            </p>
                        </div>


                    </div>
                </a>

                {{-- Actions --}}
                <div class="order-body">
                    @php
                        $disabled = !Order::allProductsDelivered($order);
                    @endphp

                    <x-filament::button :disabled="$disabled" size="xl" type="button" class="action"
                                        wire:click="changeStatus({{$order->id}}, {{Order::STATUS_FINISHED}})">
                        @if($order->status == Order::STATUS_WAITING)
                            @lang('baristaview.actions.status_ready')
                        @endif
                    </x-filament::button>
                    <x-filament::button class="action" color="gray" type="button" size="xl"
                                        wire:click="goToOrder({{ $order->id }})">
                        @lang('baristaview.actions.view')
                    </x-filament::button>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .widget-container {
            display: flex;
            justify-content: center;
        }

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

        .order-header {
            display: flex;
            justify-content: space-between;
        }

        .order-title, .order-from {
            padding: 20px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
        }

        .from-csp {
            color: #5F7C56;
            background-color: rgba(152, 188, 141, 0.28);
            border: 1px solid #5F7C56;
            border-radius: 10px;
            text-align: center;
            width: 100px;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .from-erp {
            color: gray;
            background-color: rgba(213, 213, 213, 0.29);
            border: 1px solid gray;
            border-radius: 10px;
            text-align: center;
            width: 100px;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .order-separator {
            margin-bottom: 10px;
        }

        .order-body {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .product-list {
            display: flex;
            flex-direction: column;
        }

        .product-list-item {
            margin-left: 10px;
        }

        .time {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .times {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .success {
            color: #41a564;
        }

        .warning {
            color: #cda439;
        }

        .danger {
            color: #D96153;
        }

        @media (min-width: 640px) {
            .order-card {
                width: 100%;
            }
        }


        @media (min-width: 1024px) {
            .order-card {
                width: 48%;
            }
        }

        @media (min-width: 1280px) {
            .order-card {
                width: 48%;
            }
        }
    </style>
</x-filament-widgets::widget>
