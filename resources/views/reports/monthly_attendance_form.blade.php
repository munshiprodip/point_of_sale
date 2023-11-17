@extends('layouts.datatable')
@section('title', 'Generate Attendance Report')

@section('content')
<form autocomplete=off method="GET" action="{{ route('reports.monthly_attendance_report') }}" target="_blank">
    @csrf
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Monthly attendance report</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 p-5 border rounded">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pt-4 ">
                                    <label >Any date of month</label>
                                    <input type="text" name="date" class="form-control flatpickr-input pick-date" placeholder="YYYY-MM-DD" required readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 p-5 border rounded">
                        <div class="row">
                            <div class="col-sm-12">                               
                                <div class="pt-4">
                                    <label >Department</label>
                                    <select name="department_id" class="form-control">
                                        <option value="0">All Employee</option>
                                        @foreach($departments as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 px-5 py-3 border rounded text-center">
                        <button class="btn btn-primary w-100" type="submit">RUN REPORT</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


@endsection


@section('script')
   <script>
        

   </script>
@endsection