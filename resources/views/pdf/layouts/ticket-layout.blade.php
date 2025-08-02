<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Ticket')</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        @page {
            margin: 0.5cm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .ticket {
            max-width: 100%;
            padding: 5px;
        }

        .title {
            font-size: 12px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .items {
            margin-top: 10px;
            padding: 5px 0;
        }

        .item {
            padding-left: 20px;
            overflow: hidden; /* Para contener los floats */
            margin-bottom: 2px;
        }

        .item-name {
            float: left;
            width: 70%;
        }

        .item-price {
            float: right;
            width: 30%;
            text-align: right;
        }

        .id-text {
            font-size: 16px;
        }

        .id-value {
            font-size: 20px;
            letter-spacing: 3px;
        }

        .total {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="ticket">
    @yield('content')
</div>
</body>
</html>
