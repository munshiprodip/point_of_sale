@extends('layouts.datatable')
@section('title', 'Attendances')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th width="20px" >SL</th>
                        <th>NAME</th>
                        <th width="15%" >EMPLOYEE ID</th>
                        <th width="12%" >STATUS</th>
                        <th width="12%" >DUTY IN</th>
                        <th width="12%" >DUTY OUT</th>
                        <th width="12%" >LATE IN</th>
                        <th width="12%" >EARLY LEAVE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        @php
                            if(count($employee->dateWiseAttendance)){
                                $attendance = $employee->dateWiseAttendance[0];
                            }else{
                                $attendance = (object) [
                                        'attendance_status' => false,
                                        'entry_time' => false,
                                        'exit_time' => false,
                                        'late_entry_time' => false,
                                        'erly_exit_time' => false,
                                    ];
                            }
                        @endphp
                
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->employment_id }}</td>
                            <td><span class="badge me-1 bg-label-{{ $attendance->attendance_status? 'primary': 'danger' }}" >{{ $attendance->attendance_status? "Present": "Absent" }}</span></td>
                            <td>{{ $attendance->entry_time }}</td>
                            <td>{{ $attendance->exit_time }}</td>
                            <td>{{ $attendance->late_entry_time }}</td>
                            <td>{{ $attendance->erly_exit_time }}</td>
                        </tr>
                    @endforeach
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
            data_table = data_table.DataTable(); 
        });
    </script>
@endsection