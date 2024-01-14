<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            header: page-header;
            footer: page-footer;
            margin-left:70px;
            margin-right:70px;
        }
        body{
            font-size: 12px;
        }
        .collapse-table {
            border-collapse: collapse;
            width:100%;
        }
        .collapse-table td, .collapse-table th{
            padding:5px;
            vertical-align: top;
            border: 1px solid #dddddd;
        }
        
       
    </style>
</head>

<body>
    <htmlpageheader name="page-header" >
        <div style="text-align:center;">
            <h3 style="margin:0; font-size:22px;">{{ auth()->user()->shop->name }}</h3>
            <p>{{ auth()->user()->shop->header_text }}</p>
            <p>{{ auth()->user()->shop->address }}</p>
            <hr>
        <p style="margin:0; text-decoration:underline; font-size:16px;">Invoice :  {{ $invoice->invoice_uid }}</p>
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <table width="100%" >
            <tr>
                <td width="50%">
                Sold by: {{ $invoice->createdBy->name }} Date : {{ $invoice->created_at }}
                </td>
                <td style="text-align:right" width="50%">
                    Point of sale, Developed by: KYAMCH IT
                </td>
            </tr>
        </table>
    </htmlpagefooter>


    <main style="word-wrap: break-word;">
        <table>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>{{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>:</td>
                <td>{{ $invoice->customer_name }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>:</td>
                <td>{{ $invoice->customer_phone }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>:</td>
                <td>{{ $invoice->customer_address }}</td>
            </tr>
        </table>
        <table class="collapse-table" style="margin-top:20px;" >
            <thead>
                <tr>
                    <td>SL</td>
                    <td>SKU</td>
                    <td>PRODUCT NAME</td>
                    <td>UNIT PRICE</td>
                    <td>QUANTITY</td>
                    <td>TOTAL</td>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->invoice_items as $item)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$item->product->sku}}</td>
                    <td>{{$item->product->name}}</td>
                    <td>{{$item->unit_price}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->total_price}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan=5 style="text-align:right;">Sub total</td>
                    <td>{{$invoice->sub_total }}</td>
                </tr>
                <tr>
                    <td colspan=5 style="text-align:right;">VAT</td>
                    <td>{{$invoice->vat }}</td>
                </tr>
                <tr>
                    <td colspan=5 style="text-align:right;">Discount</td>
                    <td>{{$invoice->discount }}</td>
                </tr>
                <tr>
                    <td colspan=5 style="text-align:right;"><strong>Total</strong> </td>
                    <td><strong> {{$invoice->total }} </strong> </td>
                </tr>
                <tr>
                    <td colspan=5 style="text-align:right;">Paid</td>
                    <td>{{$invoice->paid_amount }}</td>
                </tr>
                <tr>
                    <td colspan=5 style="text-align:right;"><strong>Due</strong> </td>
                    <td><strong> {{ number_format(($invoice->total - $invoice->paid_amount), 2) }} </strong> </td>
                </tr>
            </tbody>
        </table>
        In word: 
    </main>

</body>


</html>