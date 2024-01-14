<!DOCTYPE html>
<html>
<head>
    <title>Invoice | KYAMCH</title>
    <style>
        @page {
            margin:5px 15px;
        }

        #watermark {
            position: fixed;
            top: 30%;
            width: 100%;
            text-align: center;
            opacity: .4;
            transform: rotate(-45deg);
            transform-origin: 50% 50%;
            z-index: -1000;
            font-size: 50px;
        }
    </style>
</head>
<body style="text-align:center;">
    <div id="watermark">
        {{ $order->status? "PAID" : "DUE"}}
    </div>

    <h4 style="margin:0;margin-top:15px; font-family:Maiandra GD !important;">{{ $order->shop->header_text }}</h4>
    <p style="margin:0;">{{ $order->shop->address }}</p>
    <p style="margin:0;">{{ date('d-m-Y h:i:a')}}</p>

    <hr>
    <p style="margin:0; font-weight:bold;">#{{ $order->invoice_uid }}</p>
    <hr>

    <table width="100%">
        @php
            $i = 0;
        @endphp
        @foreach ($order->invoice_items as $row)
            <tr>
                <td style="vertical-align: top;">{{ ++$i }}.</td>
                <td>{{ $row->product->name .' - '. (int)$row->quantity .'pc'}}</td>
                <td style="text-align:right; vertical-align: top;">{{ $row->total_price}}</td>
            </tr>
        @endforeach
    </table>

    <hr>

    <table width="100%" cellspacing="0">
        <tr>
            <td style="text-align:right">Total:</td>
            <td style="text-align:right">{{ $order->total }}</td>
        </tr>
        <tr>
            <td style="text-align:right">Paid:</td>
            <td style="text-align:right">{{ $order->paid_amount }}</td>
        </tr>
        <tr >
            <td style="text-align:right; border-top:1px solid #000;">Due:</td>
            <td style="text-align:right; border-top:1px solid #000;">{{ number_format(($order->total - $order->paid_amount), 2) }}</td>
        </tr>
    </table>

    <hr>

    <p style="margin:0;">Products sold are nonrefundable.</p>
    <p style="margin:0;">Thank you.</p>
</body>

</html>