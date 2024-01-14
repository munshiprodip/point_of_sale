<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\User;
use App\Models\Invoice;
use App\Models\DamageItem;
use App\Models\CashDeposite;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{

    // Stock report (Current stock) (Product wise)
    // Purchase report (Periodical) (Product wise)
    // Sells/Invoice Report (Periodical) (Product wise) (User wise) - If all user groupd by user
    // Damage report (Periodical) (Product wise) 
    // Cash handover report (Periodical) (User wise) - If all user groupd by user


    public function stock_form()
    {
        $products = Product::all();
        return view('reports.stock_form', compact('products'));
    }

    public function stock_report(Request $request)
    {
        $date = Carbon::now()->toDateString();
        $report_title = 'Stock Report';
        $i = 0;

        if($request->product_id){
            $products = Product::where('id', $request->product_id)->get();
        }else{
            $products = Product::all();
        }

        $pdf = PDF::loadView('reports.pdf.stock_report', compact('products', 'i', 'date', 'report_title'))->setPaper('A4', 'landscape');
        return $pdf->stream();
    }




    public function purchase_form()
    {
        $products = Product::all();
        return view('reports.purchase_form', compact('products'));
    }

    public function purchase_report(Request $request)
    {
        $from_date  = Carbon::parse($request->from_date)->toDateString();
        $to_date    = Carbon::parse($request->to_date)->addDay(1)->toDateString();

        $date = Carbon::now()->toDateString();
        $report_title = 'Purchase Report '. $request->from_date . "-" . $request->to_date;
        $i = 0;
        $purchases = PurchaseItem::wherehas('purchase', function($q){
            $q->where('shop_id', auth()->user()->shop->id);
        })
        ->whereBetween('created_at', [$from_date, $to_date]);

        if($request->product_id){
            $purchases = $purchases->where('product_id', $request->product_id);
        }
        
        $purchases = $purchases->get();
        
        $pdf = PDF::loadView('reports.pdf.purchase_report', compact('purchases', 'i', 'date', 'report_title'))->setPaper('A4', 'landscape');
        return $pdf->stream();
    }




    public function damage_form()
    {
        $products = Product::all();
        return view('reports.damage_form', compact('products'));
    }

    public function damage_report(Request $request)
    {
        $from_date  = Carbon::parse($request->from_date)->toDateString();
        $to_date    = Carbon::parse($request->to_date)->addDay(1)->toDateString();

        $date = Carbon::now()->toDateString();
        $report_title = 'Damage Report '. $request->from_date . "-" . $request->to_date;
        $i = 0;
        $damageses = DamageItem::where('shop_id', auth()->user()->shop->id)
        ->where('status', 1)
        ->whereBetween('created_at', [$from_date, $to_date]);

        if($request->product_id){
            $damageses = $damageses->where('product_id', $request->product_id);
        }
        
        $damageses = $damageses->get();
        
        $pdf = PDF::loadView('reports.pdf.damage_report', compact('damageses', 'i', 'date', 'report_title'))->setPaper('A4', 'landscape');
        return $pdf->stream();
    }


    public function cash_deposite_form()
    {
        $users = User::all();
        return view('reports.cash_deposite_form', compact('users'));
    }

    public function cash_deposite_report(Request $request)
    {
        $from_date  = Carbon::parse($request->from_date)->toDateString();
        $to_date    = Carbon::parse($request->to_date)->addDay(1)->toDateString();

        $date = Carbon::now()->toDateString();
        $report_title = 'Cash Handover Report '. $request->from_date . "-" . $request->to_date;
        $i = 0;
        $cash_deposites = CashDeposite::with('createdBy')->whereBetween('created_at', [$from_date, $to_date])->where('status', 1);

        if($request->user_id){
            $cash_deposites = $cash_deposites->where('created_by', $request->user_id);
        }
        
        $cash_deposites = $cash_deposites->get()->groupBy('createdBy.name');
        
        $pdf = PDF::loadView('reports.pdf.cash_deposite_report', compact('cash_deposites', 'i', 'date', 'report_title'))->setPaper('A4', 'landscape');
        return $pdf->stream();
    }




    public function sell_form()
    {
        $users = User::all();
        return view('reports.sell_form', compact('users'));
    }

    public function sell_report(Request $request)
    {
        $from_date  = Carbon::parse($request->from_date)->toDateString();
        $to_date    = Carbon::parse($request->to_date)->addDay(1)->toDateString();

        $date = Carbon::now()->toDateString();
        $report_title = 'Sells Report '. $request->from_date . "-" . $request->to_date;
        $i = 0;
        $invoices = Invoice::with('createdBy')->where('shop_id', auth()->user()->shop->id)
        ->whereBetween('created_at', [$from_date, $to_date]);

        if($request->user_id){
            $invoices = $invoices->where('created_by', $request->user_id);
        }
        
        $invoices = $invoices->get()->groupBy('createdBy.name');
       
        $pdf = PDF::loadView('reports.pdf.sell_report', compact('invoices', 'i', 'date', 'report_title'))->setPaper('A4', 'landscape');
        return $pdf->stream();
    }








    // New reports start
    public function dailyAttendanceForm()
    {
        $departments    = auth()->user()->organization->departments;
        return view('reports.daily_attendance_form', compact('departments'));
    }

    public function generateDailyAttendanceReport(Request $request)
    {
        $date = $request->date? Carbon::parse($request->date)->toDateString() : Carbon::now()->toDateString();
        $department_id = $request->department_id;
        $attendances = DailyAttendance::whereDate('date', $date)
            ->whereHas('employee', function($query) use($department_id){
                $query->where('organization_id' , auth()->user()->organization_id);
                if($department_id){
                    $query->where('department_id' , $department_id);
                }
            })->get();
        $i = 0;
        $view_blade =  auth()->user()->organization->is_track_lunch? 'reports.daily_attendance_report_with_lunch' : 'reports.daily_attendance_report';
        $pdf = PDF::loadView($view_blade, compact('attendances', 'i', 'date'), [], [
            'title' => 'Attendance report',
            'margin_top' => 35,
            'margin_bottom' => 12,
            'margin_header' => 8,
            'margin_footer' => 5,
            'format' => 'A4-L'
        ]);
        return $pdf->stream('Attendance report-'.$date.'.pdf');
    }

    public function monthlyAttendanceForm()
    {
        $departments    = auth()->user()->organization->departments;
        return view('reports.monthly_attendance_form', compact('departments'));
    }

    public function generateMonthlyAttendanceReport(Request $request)
    {
        $date = $request->date? Carbon::parse($request->date) : Carbon::now();
        $department_id = $request->department_id;
        $employees = Employee::where('status', 1)->with(['daily_attendances' => function ($query) use($date) {
            $query->whereMonth('date', $date);
        }])->where('organization_id', auth()->user()->organization_id)->get();
        $i = 0;

        $date = $date->format('F Y');
        $view_blade =  auth()->user()->organization->is_track_lunch? 'reports.monthly_attendance_report_with_lunch' : 'reports.monthly_attendance_report';
        $pdf = PDF::loadView($view_blade, compact('employees', 'i', 'date'), [], [
            'title' => 'Attendance report',
            'margin_top' => 35,
            'margin_bottom' => 12,
            'margin_header' => 8,
            'margin_footer' => 5,
            'format' => 'A4-L'
        ]);
        return $pdf->stream('Monthly attendance report-'.$date.'.pdf');
    }

    // New reports end

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
                'entry_time' =>  $entry_time? Carbon::parse($entry_time)->format('h:i A') : '',
                'exit_time' => $exit_time? Carbon::parse($exit_time)->format('h:i A'): '',
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
