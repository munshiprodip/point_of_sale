<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\DailyAttendance;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $total_employee_count       = Employee::where('organization_id', auth()->user()->organization_id)->count();
        $active_employee_count      = Employee::where('status', 1)->where('organization_id', auth()->user()->organization_id)->count();
        $disabled_employee_count    = Employee::where('status', 0)->where('organization_id', auth()->user()->organization_id)->count();
        $day_off_employee_count     = Employee::where('status', 1)->where('organization_id', auth()->user()->organization_id)
            ->whereHas('schedule', function($query){
                $dayOfWeek = lcfirst(Carbon::now()->format('l'));
                $query->where($dayOfWeek, 1);
            })->count();

        $present_count  = DailyAttendance::whereDate('date', Carbon::now())
            ->where('is_present', 1)
            ->whereHas('employee', function($query){
                $query->where('organization_id' , auth()->user()->organization_id);
            })->count();

        $absent_count  = DailyAttendance::whereDate('date', Carbon::now())
            ->where('is_present', 0)
            ->where('is_day_off', 0)
            ->whereHas('employee', function($query){
                $query->where('organization_id' , auth()->user()->organization_id);
            })->count();

        $late_in_count  = DailyAttendance::whereDate('date', Carbon::now())
            ->where('is_present', 1)
            ->where('is_day_off', 0)
            ->whereHas('employee', function($query){
                $query->where('organization_id' , auth()->user()->organization_id);
            })
            ->where(function ($query) {
                $query->where(
                    DB::raw('TIMESTAMP(in_time)'), 
                    '>', 
                    DB::raw('TIMESTAMP(schedule_in + INTERVAL ' . auth()->user()->organization->flex_time . ' MINUTE)')
                );
            })
            ->count();

        $day_off_count  = DailyAttendance::whereDate('date', Carbon::now())
            ->where('is_day_off', 1)
            ->whereHas('employee', function($query){
                $query->where('organization_id' , auth()->user()->organization_id);
            })->count();

        $log_count    = Attendance::whereDate('attendance_date', Carbon::now())->whereHas('employee', function ($query) {
                $query->where('organization_id', auth()->user()->organization_id);
            })->count();

        return view('dashboard', compact(
            'total_employee_count', 
            'active_employee_count', 
            'disabled_employee_count', 
            'day_off_employee_count', 

            'present_count', 
            'absent_count', 
            'late_in_count', 
            'day_off_count', 
            'log_count'
        ));
    }
}
