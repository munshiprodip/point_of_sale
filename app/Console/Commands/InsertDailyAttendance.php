<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\DailyAttendance;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Organization;
use Carbon\Carbon;
use DB;
use Telegram\Bot\Laravel\Facades\Telegram;


class InsertDailyAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:daily-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::where('status', 1)->get();
        $currentDate = Carbon::now();
        $dayOfWeek = lcfirst($currentDate->format('l'));

        foreach($employees as $employee){
            DailyAttendance::create([
                'employee_id'   => $employee->id,
                'date'          => date("Y-m-d"),
                'schedule_in'   => $employee->schedule->start_time,
                'schedule_out'  => $employee->schedule->end_time,
                'is_present'    => 0,
                'is_day_off'    => $employee->schedule[$dayOfWeek],
            ]); 
        }
        
        $this->notifyPreviousDaysAttendanceSummery();
        
        $this->info('Todays attendance insearted successfully.');
    }


    private function notifyPreviousDaysAttendanceSummery()
    {
        $yesterday = Carbon::now()->subDay();
        $organizations = Organization::where('status', 1)->get();

        foreach($organizations as $organization){
            $active_employee_count      = Employee::where('status', 1)->where('organization_id', $organization->id)->count();

            $present_count  = DailyAttendance::whereDate('date', $yesterday)
                ->where('is_present', 1)
                ->whereHas('employee', function($query) use($organization){
                    $query->where('organization_id' , $organization->id);
                })->count();

            $absent_count  = DailyAttendance::whereDate('date', $yesterday)
                ->where('is_present', 0)
                ->where('is_day_off', 0)
                ->whereHas('employee', function($query) use($organization){
                    $query->where('organization_id' , $organization->id);
                })->count();

            $late_in_count  = DailyAttendance::whereDate('date', $yesterday)
                ->where('is_present', 1)
                ->where('is_day_off', 0)
                ->whereHas('employee', function($query) use($organization){
                    $query->where('organization_id' , $organization->id);
                })
                ->where(function ($query) use($organization){
                    $query->where(
                        DB::raw('TIMESTAMP(in_time)'), 
                        '>', 
                        DB::raw('TIMESTAMP(schedule_in + INTERVAL ' . $organization->flex_time . ' MINUTE)')
                    );
                })
                ->count();

            $early_leave_count  = DailyAttendance::whereDate('date', $yesterday)
                ->where('is_present', 1)
                ->where('is_day_off', 0)
                ->whereHas('employee', function($query) use($organization){
                    $query->where('organization_id' , $organization->id);
                })
                ->where(function ($query) use($organization) {
                    $query->where(
                        DB::raw('TIMESTAMP(schedule_out)'), 
                        '>', 
                        DB::raw('TIMESTAMP(out_time + INTERVAL ' . $organization->flex_time . ' MINUTE)')
                    );
                })
                ->count();

            $day_off_count  = DailyAttendance::whereDate('date', $yesterday)
                ->where('is_day_off', 1)
                ->whereHas('employee', function($query) use($organization){
                    $query->where('organization_id' , $organization->id);
                })->count();


            $message = "Date: $yesterday \nTotal Employee: $active_employee_count \nDay off: $day_off_count \nPresent: $present_count \nAbsent: $absent_count \nLate In: $late_in_count \nEarly Leave: $early_leave_count";

            if($organization->notification_status){
                Telegram::sendMessage([
                    'chat_id' => $organization->chat_id,
                    'text' => $message,
                ]);
            }   

        }
        return true;
    }

}
