@php
    use App\Models\Order;
@endphp

<x-filament-widgets::widget class="widget-container">
    <div class="container">
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
                            setInterval(() => { updateTime() }, 1000);
                            intervalSet = true;
                        }
                    "
        >
            <div style="padding: 20px;">
                <div>
                    <p class="font-semibold">
                        @lang('baristaview.elapsed_time')<br>
                        <span class="font-normal time" :class="elapsedStatus" x-text="timeAgo"></span>
                    </p>
                </div>
            </div>
        </div>
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

        .order-separator {
            margin-bottom: 10px;
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

        .success {
            color: #41a564;
        }

        .warning {
            color: #cda439;
        }

        .danger {
            color: #D96153;
        }
    </style>
</x-filament-widgets::widget>
