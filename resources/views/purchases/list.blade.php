@extends('layouts.datatable')
@section('title', 'Purchase List')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>DATE</th>
                        <th>PURCHASE NO</th>
                        <th>TOTAL ITEMS</th>
                        <th>PREPARED BY</th>
                        <th>OPTIONS</th>
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
                ajax: "{{ route('purchases.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "date" },
                    { data: "purchase_uid" },
                    { data: "items_count" },
                    { data: "prepared_by" },
                    { data: (row) => {
                            return `
                                <a class="dropdown-item" href="{{route('purchases.details', ':id')}}"><i class="ti ti-eye me-1"></i> Details</a>
                            `.replace(':id', row.id);
                        } 
                    },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [5] 
                    },
                ],

                @can('Create Purchases')
                    dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    buttons: [
                        {
                        text: "NEW PURCHASE",
                        className: "add-new btn btn-primary btn-sm mb-3 mb-md-0",
                        attr: {
                            "onclick": "addData()",
                        },
                        init: function (e, a, t) {
                            $(a).removeClass("btn-secondary");
                        },
                        },
                    ],
                @endcan

                pageLength: 25,
                responsive: true,
            });

            
        });

        @can('Create Purchases')
            function addData(){
                window.location.href = `{{ route("purchases.create") }}`;
            }
        @endcan

        
    </script>
@endsection