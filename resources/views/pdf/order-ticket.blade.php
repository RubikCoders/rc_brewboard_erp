@extends('pdf.layouts.ticket-layout')

@section('title', __("order-ticket.title", ['number' => $order->id]))

@section('content')
    <div class="center bold title">{{config("app.name")}}</div>
    <hr>

    <div class="center">
        <span>@lang("order-ticket.address")</span><br>
        <span>@lang("order-ticket.city")</span><br>
        <span class="bold">@lang("order-ticket.rfc")</span>
    </div>

    <hr>

    <div>
        <span class="bold">@lang("order-ticket.date")</span><span>   {{$order->created_at->format('d/m/Y')}}</span><br>
        <span
            class="bold">@lang("order-ticket.time")</span><span>  {{$order->created_at->format('H:i')}} @lang("order-ticket.hours_suffix")</span>
    </div>
    <br>
    <div class="center">
        <span class="bold title id-text">@lang("order-ticket.id")</span><br>
        <span class="bold title id-value">{{$order->id}}</span>
    </div>

    <hr>

    <div class="items">
        <b>@lang('order-ticket.products')</b>

        <table width="100%" style="border-collapse: collapse; margin-bottom: 2px;">
            @foreach($orderProducts as $orderProduct)
                <tr>
                    <td style="padding-left: 20px;">
                        ({{$orderProduct->quantity}}) {{ $orderProduct->product->name }} </td>
                    <td class="bold" style="text-align: right;">{{ $orderProduct->total_price }}</td>

{{--                    Customizaciones --}}
                    @foreach($orderProduct->customizations as $customization)
                        @php
                        $name = $customization->customization->name;
                        $extraPrice = \App\Helpers\Money::format($customization->customization->extra_price);
                        @endphp

                        <tr>
                            <td style="padding-left: 40px;">
                                {{ $name }} </td>
                            <td style="text-align: right;">{{ $extraPrice }}</td>
                        </tr>

                    @endforeach
                </tr>
            @endforeach
        </table>

    </div>

    <hr>

    <div class="total">
        <span>
            @lang('order-ticket.subtotal', [ 'subtotal' => $order->total - $order->tax ])
        </span><br>
        <span>
            @lang('order-ticket.tax', ['tax' => $order->tax])
        </span>
        <br><br>
        <span>
            @lang('order-ticket.total', [ 'total' => $order->total ])
        </span>
    </div>

    <br>

    <div class="center">¡Gracias por su compra!</div>

    <hr>

    <div class="center">
        <span>@lang("order-ticket.footer")</span>
    </div>
@endsection
