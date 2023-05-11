<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use  Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\View;
use App\Models\Appointment;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $todays_appointments = Appointment::whereDate('created_at', Carbon::today());                   
        View::share(['todays_appointments' =>$todays_appointments]);  
    }
}
