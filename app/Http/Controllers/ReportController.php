<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function index()
    {
        $employees      = auth()->user()->organization->employees;
        $departments    = auth()->user()->organization->departments;
        return view('reports.index', compact('employees', 'departments'));
    }

    public function generateReport(Request $request)
    {
        if($request->reports_date_type=='daily' ){
            $reports_date = $request->reports_date;
            $employees = Employee::with(['attendances' => function ($query) use($reports_date) {
                $query->whereDate('attendance_date', Carbon::parse($reports_date))
                    ->whereIn('attendance_type', [0, 1])
                    ->orderBy('attendance_type')
                    ->orderBy('attendance_time');
            }])->where('organization_id', auth()->user()->organization_id);

            if($request->reports_employee_type=='department'){
                $employees = $employees->where('department_id', $request->reports_department_id);
            }elseif($request->reports_employee_type=='single'){
                $employees = $employees->where('id', $request->reports_employee_id);
            }
            
            $employees = $employees->get();
            $i = 0;
            $employees = $this->processEmployeesAttendance($employees);

            $pdf = PDF::loadView('reports.daily_general_attendances', compact('employees', 'i', 'reports_date'), [], [
                'title' => 'Attendance report',
                'margin_top' => 35,
                'margin_header' => 5,
            ]);
            return $pdf->stream('attendancereport'.'.pdf');
        
            return view('reports.daily_general_attendances', compact('employees', 'i'));
        }

        if($request->reports_date_type=='monthly' ){
            $reports_date = $request->reports_month.' '.$request->reports_year;
            $employees = Employee::with(['attendances' => function ($query) use($reports_date) {
                $query->whereMonth('attendance_date', Carbon::parse($reports_date))
                    ->whereIn('attendance_type', [0, 1])
                    ->orderBy('attendance_date')
                    ->orderBy('attendance_type')
                    ->orderBy('attendance_time');
            }])->where('organization_id', auth()->user()->organization_id);

            if($request->reports_employee_type=='department'){
                $employees = $employees->where('department_id', $request->reports_department_id);
            }elseif($request->reports_employee_type=='single'){
                $employees = $employees->where('id', $request->reports_employee_id);
            }
            
            $employees = $employees->get();
            $i = 0;

            $employees = $this->processEmployeesAttendance($employees);

            $pdf = PDF::loadView('reports.monthly_general_attendances', compact('employees', 'i', 'reports_date'), [], [
                'title' => 'Attendance report',
                'margin_top' => 30,
                'margin_header' => 10,
            ]);
            return $pdf->stream('attendancereport'.'.pdf');

            return view('reports.monthly_general_attendances', compact('employees', 'i'));
        }

        
    }







    private function processEmployeesAttendance($employees)
    {
        $procesed_employees_with_attendance = [];
        
        foreach($employees as $employee)
        {
            [$all_attendance_rows, $laet_entry_count, $erly_exit_count] = $this->processDateWiseAttendance($employee->attendances->groupBy('attendance_date'), $employee->schedule->start_time, $employee->schedule->end_time);
            
            $procesed_employees_with_attendance[] = (object) [
                'name' => $employee->name,
                'employment_id' => $employee->employment_id,
                'schedule_start_time' => Carbon::parse($employee->schedule->start_time)->format('h:i A'),
                'schedule_end_time' => Carbon::parse($employee->schedule->end_time)->format('h:i A'),

                'laet_entry_count' => $laet_entry_count,
                'erly_exit_count' => $erly_exit_count,
                'dateWiseAttendance' => $all_attendance_rows,
            ];
        }

        return  $procesed_employees_with_attendance;
    }

    private function processDateWiseAttendance($dateWiseAttendance, $schedule_start_time, $schedule_end_time)
    {
        $all_attendance_rows = [];

        $laet_entry_count = 0;
        $erly_exit_count = 0;

        foreach($dateWiseAttendance as $date => $attendances)
        {
            $entry  = $attendances->where('attendance_type', 0)->first();
            $exit   = $attendances->where('attendance_type', 1)->first();

            if($entry){
                $attendance_status = true;
                $entry_time =  $entry->attendance_time;
                $late_entry_time = $entry_time > $schedule_start_time? $this->getTimeDifference($entry_time, $schedule_start_time) : false;
                if($late_entry_time){
                    ++$laet_entry_count;
                }
            }else{
                $attendance_status = false;
                $entry_time =  false;
                $late_entry_time = false;
            }

            if($exit){
                $exit_time =  $exit->attendance_time;
                $erly_exit_time = $exit_time < $schedule_end_time? $this->getTimeDifference($exit_time, $schedule_end_time) : false;
                if($erly_exit_time){
                    ++$erly_exit_count;
                }
            }else{
                $exit_time =  false;
                $erly_exit_time = false;
            }


            $all_attendance_rows[] = (object) [
                'date' => $date,
                'attendance_status' => $attendance_status,
                'entry_time' => Carbon::parse($entry_time)->format('h:i A'),
                'exit_time' => Carbon::parse($exit_time)->format('h:i A'),
                'late_entry_time' => $late_entry_time,
                'erly_exit_time' => $erly_exit_time,
            ];
        }

        return [$all_attendance_rows, $laet_entry_count, $erly_exit_count];
    }

    private function getTimeDifference($startTime, $endTime) {
        $start = \Carbon\Carbon::createFromFormat('H:i:s', $startTime);
        $end = \Carbon\Carbon::createFromFormat('H:i:s', $endTime);
        
        $diff = $end->diff($start);
        if($diff->h == 0 && $diff->i <=14){
            return false;
        }
        return $diff->h.'h '.$diff->i.'m';
    }
}
