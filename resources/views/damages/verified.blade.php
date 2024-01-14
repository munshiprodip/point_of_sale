@extends('layouts.datatable')
@section('title', 'Damages Verified')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>PRODUCT ID</th>
                        <th>PRODUCT NAME</th>
                        <th>QUANTITY</th>
                        <th>REASON</th>
                        <th>VERIFIED BY</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>


    </div>
    <!--/ Responsive Datatable --> 
@endsection


@section('script')
    <script>
        let data_table          = $("#data_table");

        $(function(){
            data_table = data_table.DataTable({
                ajax: "{{ route('damages.verified') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "product_sku" },
                    { data: "product_name" },
                    { data: "quantity" },
                    { data: "comment" },
                    { data: "verifiedBy" },
                ],

                pageLength: 25,
                responsive: true,
            }); 
        });
        
    </script>
@endsection