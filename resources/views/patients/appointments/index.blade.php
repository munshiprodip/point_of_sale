@extends('layouts.datatable')
@section('title', 'Appointments')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>APPOINTMENT NO</th>
                        <th>REGISTRATION NO</th>
                        <th>NAME</th>
                        <th>PHONE</th>
                        <th>DATE</th>
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
                ajax: "{{ route('appointments') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "appointment_no" },
                    { data: "registration_no" },
                    { data: "name" },
                    { data: "phone" },
                    { data: "date" },
                    { data: (row) => {
                            return `
                                <a class="btn btn-success btn-sm" href="{{ route('appointments.prescribe', ':appointment_no' ) }}"><i class="ti ti-pencil me-1"></i> Prescribe</a>
                            `.replace(':appointment_no', row.appointment_no);
                        } 
                    },
                ],

                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [6] 
                    },
                ],
                pageLength: 10,
                responsive: true,
            });
        });
        
    </script>
@endsection