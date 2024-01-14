@extends('layouts.datatable')
@section('title', 'Requisition Details')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header pb-0">Requisition Date: {{ $requisition->created_at }}</h5>
        <h5 class="card-header py-0">Requisition ID:  {{ $requisition->requisition_uid }}</h5>
        <h5 class="card-header pt-0">Prepared by: {{ $requisition->createdBy->name }}</h5>
        <div class="card-datatable table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <td>SL</td>
                        <td>SKU</td>
                        <td>PRODUCT NAME</td>
                        <td>QUANTITY</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requisition->requisition_items as $item)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$item->product->sku}}</td>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->quantity}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!--/ Responsive Datatable --> 
@endsection
