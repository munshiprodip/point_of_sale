@extends('layouts.datatable')
@section('title', 'Create Appointment')

@section('content')
<form autocomplete=off method="GET" action="{{ route('reports.submit') }}" target="_blank">
    @csrf
  <div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Attendance report</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 p-5 border rounded">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="demo-inline-spacing ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reports_date_type" id="radio_reports_date_type_daily" value="daily" checked/>
                                        <label class="form-check-label" for="radio_reports_date_type_daily">Daily</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reports_date_type" id="radio_reports_date_type_monthly" value="monthly" />
                                        <label class="form-check-label" for="radio_reports_date_type_monthly">Monthly</label>
                                    </div>
                                </div>
                                <div class="pt-4 daily-fields">
                                    <input type="text" name="reports_date" id="reports_date" class="form-control flatpickr-input pick-date" placeholder="YYYY-MM-DD" id="reports_date" required readonly="readonly">
                                </div>
                                <div class="pt-4 row monthly-fields" style="display:none;">
                                    <div class="col-md-6">
                                        <select name="reports_month" id="reports_month" class="form-control">
                                            <option value="January" selected >January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="Augast">Augast</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="reports_year" id="reports_year" class="form-control">
                                            <option value="2023" selected>2023</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 p-5 border rounded">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="demo-inline-spacing ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reports_employee_type" id="radio_reports_employee_type_single" value="single" checked/>
                                        <label class="form-check-label" for="radio_reports_employee_type_single">Employee Wise</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reports_employee_type" id="radio_reports_employee_type_department" value="department" />
                                        <label class="form-check-label" for="radio_reports_employee_type_department">Department Wise</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="reports_employee_type" id="radio_reports_employee_type_all_employees" value="all_employees" />
                                        <label class="form-check-label" for="radio_reports_employee_type_all_employees">All Employees</label>
                                    </div>
                                </div>
                                <div class="pt-4 single-employee-fields">
                                    <select name="reports_employee_id" id="reports_employee_id" class="form-control" required>
                                        @foreach($employees as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="pt-4 department-employee-fields" style="display:none;">
                                    <select name="reports_department_id" id="reports_department_id" class="form-control">
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
        $('input[name="reports_date_type"]').change(function() {
            var selectedValue = $(this).val();

            // Show/hide input fields based on the selected value
            if (selectedValue === 'daily') {
                $('.daily-fields').show();
                $('.monthly-fields').hide();

                $('#reports_date').prop('required', true); 
                $('#reports_month').prop('required', false); 
                $('#reports_year').prop('required', false); 
            } else if (selectedValue === 'monthly') {
                $('.daily-fields').hide();
                $('.monthly-fields').show();

                $('#reports_date').prop('required', false); 
                $('#reports_month').prop('required', true); 
                $('#reports_year').prop('required', true); 
            }
        });

        $('input[name="reports_employee_type"]').change(function() {
            var selectedValue = $(this).val();

            // Show/hide input fields based on the selected value
            if (selectedValue === 'single') {
                $('.single-employee-fields').show();
                $('.department-employee-fields').hide();

                $('#reports_employee_id').prop('required', true); 
                $('#reports_department_id').prop('required', false); 
            } else if (selectedValue === 'department') {
                $('.single-employee-fields').hide();
                $('.department-employee-fields').show();

                $('#reports_employee_id').prop('required', false); 
                $('#reports_department_id').prop('required', true); 
            } else if (selectedValue === 'all_employees') {
                $('.single-employee-fields').hide();
                $('.department-employee-fields').hide();

                $('#reports_employee_id').prop('required', false); 
                $('#reports_department_id').prop('required', false); 
            }
        });

   </script>
@endsection