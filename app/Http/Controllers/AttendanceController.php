<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    function __construct()
    {
        //$this->middleware('permission:Medication Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        $employees = Employee::with(['attendances' => function ($query){
            $query->whereDate('attendance_date', Carbon::now())
                ->whereIn('attendance_type', [0, 1])
                ->orderBy('attendance_type')
                ->orderBy('attendance_time');
        }])
        ->where('organization_id', auth()->user()->organization_id)
        ->get();

        $i = 0;
        $employees = $this->processEmployeesAttendance($employees);


        return view('attendances.index', compact('employees', 'i'));
    }

    public function attendancelogs(Request $request)
    {
        if($request->ajax()){
            $attendances = Attendance::whereHas('employee', function ($query) {
                $query->where('organization_id', auth()->user()->organization_id);
            })
                ->orderBy('attendance_date');
            
            return DataTables::of($attendances)
                ->addColumn('employee', function ($row) {
                    return $row->employee->name;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('attendances.attendance_log');
    }

    public function store(Request $request)
    {
        $secret = $request->key;
        $attendances = $request->data;
        
        DB::beginTransaction();
        $i = 0;
        try {
            foreach ($attendances as $row) {
                $dateTime = Carbon::createFromTimestamp($row['date_time']);
                $attendance = Attendance::create([
                    'employee_id'     => $row['user_id'],
                    'attendance_date' => $dateTime->format('Y-m-d'),
                    'attendance_time' => $dateTime->format('H:i:s'),
                    'attendance_type' => $row['access_type'],
                ]);
                $i++;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success'   => false,
                'message'   => 'Upload failed',
            ]);
        }

        return response()->json([
            'success'   => true,
            'message'   => $i.' rows uploaded',
        ]);
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
        $start = Carbon::createFromFormat('H:i:s', $startTime);
        $end = Carbon::createFromFormat('H:i:s', $endTime);
        
        $diff = $end->diff($start);
        if($diff->h == 0 && $diff->i <=14){
            return false;
        }
        return $diff->h.'h '.$diff->i.'m';
    }

}


