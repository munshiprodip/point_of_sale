@extends('layouts.datatable')
@section('title', 'Employee Details')

@section('content')

    <div class="card mb-3">
        <table class="m-3">
            <tr>
                <td>Name : {{$employee->name}}</td>
                <td>Employee ID : {{$employee->employment_id}}</td>
                <td>Designation : {{$employee->designation}}</td>
            </tr>
        </table>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="data_table" >
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>DATE</th>
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
                ajax: "{{ route('employees.show', $employee->id) }}",
                processing:true,
                serverSide:true,
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false},
                    { data: "attendance_date" },
                    { data: "attendance_time" },
                    { data: (row) => {
                            return `<span style="cursor:pointer;" class="badge me-1 bg-label-info"  > ${row.attendance_type===0? 'DutyIn': row.attendance_type===1?'DutyOut':row.attendance_type===2?'LunchOut': row.attendance_type===3?'LunchIn': 'Unknown'}</span>`;
                        }
                    },
                ],
                columnDefs: [
                    { 
                        'searchable'    : false, 
                        'targets'       : [3] 
                    },
                ],
                
                pageLength: 25,
                responsive: true,
            }); 
        });
    </script>
@endsection