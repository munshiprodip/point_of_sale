<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appointment;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        $total_appointments_count     = Appointment::where('created_by', auth()->id())->count();
        $todays_appointments_count    = Appointment::where('created_by', auth()->id())->whereDate('created_at', Carbon::today())->count();
        $weekly_appointments_count    = Appointment::where('created_by', auth()->id())->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->count();
        $monthly_appointments_count   = Appointment::where('created_by', auth()->id())->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->startOfMonth()->addMonth()])->count();

        $total_appointments_fee     = Appointment::where('created_by', auth()->id())->sum('appointment_fee');
        $todays_appointments_fee    = Appointment::where('created_by', auth()->id())->whereDate('created_at', Carbon::today())->sum('appointment_fee');
        $weekly_appointments_fee    = Appointment::where('created_by', auth()->id())->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])->sum('appointment_fee');
        $monthly_appointments_fee   = Appointment::where('created_by', auth()->id())->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->startOfMonth()->addMonth()])->sum('appointment_fee');
        
        return view('dashboard',  compact('total_appointments_count', 'todays_appointments_count', 'weekly_appointments_count', 'monthly_appointments_count', 'total_appointments_fee', 'todays_appointments_fee', 'weekly_appointments_fee', 'monthly_appointments_fee'));
    }
}
