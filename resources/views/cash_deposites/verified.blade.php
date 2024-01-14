@extends('layouts.datatable')
@section('title', 'Deposite History')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>USER</th>
                        <th>DESCRIPTION</th>
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
                ajax: "{{ route('cash_deposites.verified') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "user_name" },
                    { data: "description" },
                    { data: "amount" },
                    { data: "receiver_name" },
                ],

                pageLength: 25,
                responsive: true,
            }); 
        });
        
    </script>
@endsection