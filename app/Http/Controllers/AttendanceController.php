<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Attendance;
use App\Models\DailyAttendance;
use App\Models\Employee;
use Carbon\Carbon;
use Telegram\Bot\Laravel\Facades\Telegram;


class AttendanceController extends Controller
{
    function __construct()
    {
        //$this->middleware('permission:Permission name');
    }

    public function viewAttendance(Request $request)
    {
        $date = $request->date? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString();
        $todays_attendances = DailyAttendance::whereDate('date', $date)
            ->whereHas('employee', function($query){
                $query->where('organization_id' , auth()->user()->organization_id);
            })->get();
        $i = 0;
        
        $view_blade =  auth()->user()->organization->is_track_lunch? 'attendances.view_with_lunch' : 'attendances.view';
        return view($view_blade, compact('todays_attendances', 'date', 'i'));
    }
    

    public function lateIn(Request $request)
    {
        $late_ins  = DailyAttendance::whereDate('date', Carbon::now())
            ->where('is_present', 1)
            ->where('is_day_off', 0)
            ->where(function ($query) {
                $query->where(
                    DB::raw('TIMESTAMP(in_time)'), 
                    '>', 
                    DB::raw('TIMESTAMP(schedule_in + INTERVAL ' . auth()->user()->organization->flex_time . ' MINUTE)')
                );
            })
            ->whereHas('employee', function($query){
                $query->where('organization_id' , auth()->user()->organization_id);
            })->get();

        $i = 0;
        return view('attendances.late_ins', compact('late_ins', 'i'));
    }

    public function attendancelogs(Request $request)
    {
        if($request->ajax()){
            $attendances = Attendance::whereDate('attendance_date', Carbon::now())->whereHas('employee', function ($query) {
                $query->where('organization_id', auth()->user()->organization_id);
            });
            
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
        // check the API key
        if($request->key != env('API_KEY')){
            return response()->json([
                'success'   => false,
                'message'   => "Invalid API key",
            ]);
        }
        // get attendance log from request
       $log = $request->data;

        if($log){
            $attendance_type = $log['access_type']; // in = 0, out = 1, undefined = 255;
            $dateTime = Carbon::createFromTimestamp($log['date_time'])->subHours(6);
            $employee = Employee::where('id', $log['user_id'])->first();
            
            if($employee){
                $todays_attendance = DailyAttendance::where('date', $dateTime->format('Y-m-d'))->where('employee_id', $log['user_id'])->first();
                $attendance = Attendance::create([
                    'employee_id'     => $log['user_id'],
                    'attendance_date' => $dateTime->format('Y-m-d'),
                    'attendance_time' => $dateTime->format('H:i:s'),
                    'attendance_type' => $log['access_type'],
                ]);

                if(!$todays_attendance){
                    DailyAttendance::create([
                        'employee_id'   => $log['user_id'],
                        'date'          => $dateTime->format('Y-m-d'),

                        'in_time'       => $attendance_type == 0? $dateTime->format('H:i:s') : NULL,
                        'out_time'      => $attendance_type == 1? $dateTime->format('H:i:s') : NULL,

                        'schedule_in'   => $employee->schedule->start_time,
                        'schedule_out'  => $employee->schedule->end_time,

                        'lunch_out'       => $attendance_type == 2? $dateTime->format('H:i:s') : NULL,
                        'lunch_in'      => $attendance_type == 3? $dateTime->format('H:i:s') : NULL,

                        'is_present'    => $attendance_type == 0? 1 : 0,
                    ]);
                }else{
                    if($attendance_type == 0 && !$todays_attendance->in_time){
                        $todays_attendance->in_time = $dateTime->format('H:i:s');
                        $todays_attendance->is_present = 1;
                        $todays_attendance->save();
                    }elseif($attendance_type == 1){
                        $todays_attendance->out_time = $dateTime->format('H:i:s');
                        $todays_attendance->save();
                    }elseif($attendance_type == 2){
                        $todays_attendance->lunch_out = $todays_attendance->lunch_out? $todays_attendance->lunch_out : $dateTime->format('H:i:s');
                        $todays_attendance->save();
                    }elseif($attendance_type == 3){
                        $todays_attendance->lunch_in = $todays_attendance->lunch_in? $todays_attendance->lunch_in : $dateTime->format('H:i:s');
                        $todays_attendance->save();
                    }
                    
                }

                $chat_id                = $employee->organization->chat_id;
                $notification_status    = $employee->organization->notification_status;
                $attendance_type_text   = $attendance_type? "Checked-Out":"Checked-In";

                $message = "ID: $employee->employment_id \nName: $employee->name \nJust $attendance_type_text. \nTime: ".$dateTime->format('h:i A');
                
                // Telegram::sendMessage([
                //     'chat_id' => $chat_id,
                //     'text' => $message,
                // ]);
                if($notification_status){
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $message,
                    ]);
                }
            }

        }else{
            return response()->json([
                'success'   => true,
                'message'   => Carbon::now().' - '.'0 rows insearted',
            ]); 
        }

        return response()->json([
            'success'   => true,
            'message'   => Carbon::now().' - '.$log['user_id'].' has insearted',
        ]);
    }

    public function storeLogFromBiostar2(Request $request)
    {
        $secret = $request->key;
        // check the API key
        if($request->key != env('API_KEY')){
            return response()->json([
                'success'   => false,
                'message'   => "Invalid API key",
            ]);
        }
        // get attendance log from request
       $log = $request->data;

        if($log){
            $attendance_type = $log['access_type']; // in = 0, out = 1, lunch_out = 2, lunch_in = 3;
            $dateTime = Carbon::parse($log['date_time'])->addHours(6);
            $employee = Employee::where('id', $log['user_id'])->first();
            
            if($employee){
                $todays_attendance = DailyAttendance::where('date', $dateTime->format('Y-m-d'))->where('employee_id', $log['user_id'])->first();
                $attendance = Attendance::create([
                    'employee_id'     => $log['user_id'],
                    'attendance_date' => $dateTime->format('Y-m-d'),
                    'attendance_time' => $dateTime->format('H:i:s'),
                    'attendance_type' => $log['access_type'],
                ]);

                if(!$todays_attendance){
                    DailyAttendance::create([
                        'employee_id'   => $log['user_id'],
                        'date'          => $dateTime->format('Y-m-d'),

                        'in_time'       => $attendance_type == 0? $dateTime->format('H:i:s') : NULL,
                        'out_time'      => $attendance_type == 1? $dateTime->format('H:i:s') : NULL,

                        'schedule_in'   => $employee->schedule->start_time,
                        'schedule_out'  => $employee->schedule->end_time,

                        'lunch_out'       => $attendance_type == 2? $dateTime->format('H:i:s') : NULL,
                        'lunch_in'      => $attendance_type == 3? $dateTime->format('H:i:s') : NULL,

                        'is_present'    => $attendance_type == 0? 1 : 0,
                    ]);
                }else{
                    if($attendance_type == 0 && !$todays_attendance->in_time){
                        $todays_attendance->in_time = $dateTime->format('H:i:s');
                        $todays_attendance->is_present = 1;
                        $todays_attendance->save();
                    }elseif($attendance_type == 1){
                        $todays_attendance->out_time = $dateTime->format('H:i:s');
                        $todays_attendance->save();
                    }elseif($attendance_type == 2){
                        $todays_attendance->lunch_out = $todays_attendance->lunch_out? $todays_attendance->lunch_out : $dateTime->format('H:i:s');
                        $todays_attendance->save();
                    }elseif($attendance_type == 3){
                        $todays_attendance->lunch_in = $todays_attendance->lunch_in? $todays_attendance->lunch_in : $dateTime->format('H:i:s');
                        $todays_attendance->save();
                    }
                    
                }

                $chat_id                = $employee->organization->chat_id;
                $notification_status    = $employee->organization->notification_status;
                $attendance_type_text   = $attendance_type == 0? "Checked-In" : ($attendance_type == 1? "Checked-Out" : ($attendance_type == 2? "Lunch-Out" : ($attendance_type == 3? "Lunch-In" : "Not specified")));

                $message = "ID: $employee->employment_id \nName: $employee->name \nJust $attendance_type_text. \nTime: ".$dateTime->format('h:i A');
                
                // Telegram::sendMessage([
                //     'chat_id' => $chat_id,
                //     'text' => $message,
                // ]);
                if($notification_status){
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $message,
                    ]);
                }
            }

        }else{
            return response()->json([
                'success'   => true,
                'message'   => Carbon::now().' - '.'0 rows insearted',
            ]); 
        }

        return response()->json([
            'success'   => true,
            'message'   => Carbon::now().' - '.$log['user_id'].' has insearted',
        ]);
    }

 

    
    private function processEmployeesAttendance($employees)
    {
        $procesed_employees_with_attendance = [];
        
        foreach($employees as $employee)
        {
            [$all_attendance_rows, $laet_entry_count, $erly_exit_count] = $this->processDateWiseAttendance($employee->attendances->groupBy('attendance_date'), $employee->schedule->start_time, $employee->schedule->end_time);
            
            $procesed_employees_with_attendance[] = (object) [
                'id' => $employee->id,
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
                'entry_time' =>  $entry_time? Carbon::parse($entry_time)->format('h:i A') : '',
                'exit_time' => $exit_time? Carbon::parse($exit_time)->format('h:i A'): '',
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


