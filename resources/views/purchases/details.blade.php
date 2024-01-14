@extends('layouts.datatable')
@section('title', 'Purchases Details')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header pb-0">Purchase Date: {{ $purchase->created_at }}</h5>
        <h5 class="card-header py-0">Purchase ID:  {{ $purchase->purchase_uid }}</h5>
        <h5 class="card-header pt-0">Prepared by: {{ $purchase->createdBy->name }}</h5>
        <div class="card-datatable table-responsive">
            <table class="table" >
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
                    @php $gt=0; @endphp
                    @foreach($purchase->purchase_items as $item)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$item->product->sku}}</td>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->unit_price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->total_price}}</td>
                        @php $gt +=$item->total_price; @endphp
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan=5 style="text-align:right;">Total</td>
                        <td>{{$gt}}.00</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
    <!--/ Responsive Datatable --> 
@endsection
