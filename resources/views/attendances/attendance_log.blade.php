@extends('layouts.datatable')
@section('title', 'Attendances Log')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>DATE</th>
                        <th>EMPLOYEE NAME</th>
                        <th>TIME</th>
                        <th>TYPE</th>
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
        let data_table  = $("#data_table");

        $(function(){
            data_table = data_table.DataTable({
                ajax: "{{ route('attendances.attendancelogs') }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "attendance_date" },
                    { data: "employee" },
                    { data: "attendance_time" },
                    { data: (row) => {
                            return `<span style="cursor:pointer;" class="badge me-1 bg-label-info"  > ${row.attendance_type===0? 'DutyIn': row.attendance_type===1?'DutyOut':row.attendance_type===2?'LunchOut': row.attendance_type===3?'LunchIn': 'Unknown'}</span>`;
                        }
                    },
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