@extends('layouts.datatable')
@section('title', 'Requisition List')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>DATE</th>
                        <th>REQUISITION NO</th>
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
                ajax: "{{ route('requisitions.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "date" },
                    { data: "requisition_uid" },
                    { data: "items_count" },
                    { data: "prepared_by" },
                    { data: (row) => {
                            return `
                                <a class="dropdown-item" href="{{route('requisitions.details', ':id')}}"><i class="ti ti-eye me-1"></i> Details</a>
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
                dom: '<"row mx-1"<"col-sm-12 col-md-3" l><"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1"<"me-3"f>B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [
                    {
                    text: "NEW REQUISITION",
                    className: "add-new btn btn-primary btn-sm mb-3 mb-md-0",
                    attr: {
                        "onclick": "addData()",
                    },
                    init: function (e, a, t) {
                        $(a).removeClass("btn-secondary");
                    },
                    },
                ],
                pageLength: 25,
                responsive: true,
            });

            
        });
        
        function addData(){
            window.location.href = `{{ route("requisitions.create") }}`;
        }

        
    </script>
@endsection