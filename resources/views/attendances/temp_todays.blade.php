@extends('layouts.datatable')
@section('title', 'Todays Attendances')

@section('content')
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table" id="data_table">
                <thead>
                    <tr>
                        <th width="50px" >SL</th>
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
                    @foreach($todays_attendances as $attendance)
                        @if($attendance->is_day_off)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $attendance->employee->name }}</td>
                                <td>{{ $attendance->employee->employment_id }}</td>
                                <td style="color:green">Day off</td>
                                <td colspan="4" >Weekly holyday</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $attendance->employee->name }}</td>
                                <td>{{ $attendance->employee->employment_id }}</td>
                                <td style="color:{{ $attendance->is_present? '': 'red' }};">{{ $attendance->is_present? "Present": "Absent" }}</td>
                                <td>{{ $attendance->in_time? \Carbon\Carbon::parse($attendance->in_time)->format('h:i A') : '' }}</td>
                                <td>{{ $attendance->out_time? \Carbon\Carbon::parse($attendance->out_time)->format('h:i A') : '' }}</td>
                                <td>
                                    @php
                                        $scheduleIn = \Carbon\Carbon::parse($attendance->schedule_in);
                                        $inTime = \Carbon\Carbon::parse($attendance->in_time);

                                        if ($attendance->in_time && $inTime->gt($scheduleIn)) {
                                            $timeDifference = $inTime->diff($scheduleIn);
                                            echo $timeDifference->format('%H h %I m');
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $scheduleOut = \Carbon\Carbon::parse($attendance->schedule_out);
                                        $outTime = \Carbon\Carbon::parse($attendance->out_time);
                                        
                                        if ($attendance->out_time && $scheduleOut->gt($outTime)) {
                                            $timeDifference = $scheduleOut->diff($outTime);
                                            echo $timeDifference->format('%H h %I m');
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endif
                        
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <!--/ Responsive Datatable --> 
@endsection


@section('script')
    <script>
        
    </script>
@endsection