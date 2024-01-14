@extends('layouts.datatable')
@section('title', 'Stock Report')

@section('content')
<form autocomplete=off method="GET" action="{{ route('reports.stock_report') }}" target="_blank">
    @csrf
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Stock Report</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 p-5 border rounded">
                        <div class="row">
                            <div class="col-sm-12">                               
                                <div class="pt-4">
                                    <label >Product</label>
                                    <select name="product_id" class="form-control">
                                        <option value="0">All Product</option>
                                        @foreach($products as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 px-5 py-3 border rounded text-center">
                        <button class="btn btn-primary w-100" type="submit">RUN REPORT</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


@endsection


@section('script')
   <script>
        

   </script>
@endsection