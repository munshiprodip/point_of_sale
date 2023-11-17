@extends('layouts.datatable')
@section('title', 'View Attendances')

@section('content')
    <div class="card p-3 my-3">
        <form action="{{route('attendances.view')}}">
            <div class="row">
                <div class="col-3">
                    <input name="date" type="text" class="form-control flatpickr-input pick-date" placeholder="YYYY-MM-DD" required readonly="readonly" value="{{$date}}"/>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary">SHOW</button>
                </div>
            </div>
        </form>  
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive ">
            <table class="table table-bordered" id="data_table">
                <thead>
                    <tr>
                        <th rowspan=2 >SL</th>
                        <th rowspan=2 >NAME</th>
                        <th rowspan=2 >EMPLOYEE ID</th>
                        <th rowspan=2 >STATUS</th>
                        <th colspan=2 >SCHEDULE</th>
                        <!-- <th >END</th> -->
                        <th colspan=2 >ATTENDANCE</th>
                        <!-- <th >DUTY OUT</th> -->
                        <th colspan=2 >LATE IN / EARLY LEAVE</th>
                        <!-- <th >EARLY LEAVE</th> -->
                    </tr>
                    <tr>
                        <!-- <th width="50px" >SL</th> -->
                        <!-- <th>NAME</th> -->
                        <!-- <th >EMPLOYEE ID</th> -->
                        <!-- <th >STATUS</th> -->
                        <th >START</th>
                        <th >END</th>
                        <th >IN</th>
                        <th >OUT</th>
                        <th >LI</th>
                        <th >EL</th>
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
                                <td colspan="6" style="text-align:center" >Weekly holyday</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $attendance->employee->name }}</td>
                                <td>{{ $attendance->employee->employment_id }}</td>
                                <td style="color:{{ $attendance->is_present? '': 'red' }};">{{ $attendance->is_present? "Present": "Absent" }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->schedule_in)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->schedule_out)->format('h:i A') }}</td>
                                <td>{{ $attendance->in_time? \Carbon\Carbon::parse($attendance->in_time)->format('h:i A') : '' }}</td>
                                <td>{{ $attendance->out_time? \Carbon\Carbon::parse($attendance->out_time)->format('h:i A') : '' }}</td>
                                <td>
                                    @php
                                        $scheduleIn = \Carbon\Carbon::parse($attendance->schedule_in);
                                        $scheduleInWithFlexTime = \Carbon\Carbon::parse($attendance->schedule_in)->addMinutes(auth()->user()->organization->flex_time);
                                        $inTime = \Carbon\Carbon::parse($attendance->in_time);

                                        if ($attendance->in_time && $inTime->gt($scheduleInWithFlexTime)) {
                                            $timeDifference = $inTime->diff($scheduleIn);
                                            echo $timeDifference->format('%H h %I m');
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $scheduleOut = \Carbon\Carbon::parse($attendance->schedule_out);
                                        $outTime = \Carbon\Carbon::parse($attendance->out_time);
                                        $outTimeWithFlexTime = \Carbon\Carbon::parse($attendance->out_time)->addMinutes(auth()->user()->organization->flex_time);
                            
                                        if ($attendance->out_time && $scheduleOut->gt($outTimeWithFlexTime)) {
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