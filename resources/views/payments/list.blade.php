@extends('layouts.datatable')
@section('title', 'Payment List')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>DATE</th>
                        <th>VOUCHER NO</th>
                        <th>AMOUNT</th>
                        <th>RECEIVED BY</th>
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
                ajax: "{{ route('payments.list') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "date" },
                    { data: "payment_uid" },
                    { data: "amount" },
                    { data: "received_by" },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [4] 
                    },
                ],
                
                pageLength: 25,
                responsive: true,
            });

            
        });
        
        
    </script>
@endsection