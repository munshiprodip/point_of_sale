<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Purchase;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
       

        $todays_sells = Invoice::where('shop_id', auth()->user()->shop_id)->whereDate('created_at', Carbon::now() )->sum('total');
        $this_month_sells = Invoice::where('shop_id', auth()->user()->shop_id)->whereMonth('created_at', Carbon::now() )->sum('total');
        $this_year_sells = Invoice::where('shop_id', auth()->user()->shop_id)->whereYear('created_at', Carbon::now() )->sum('total');
        $total_sells = Invoice::where('shop_id', auth()->user()->shop_id)->sum('total');
        $total_purchases = Purchase::where('shop_id', auth()->user()->shop_id)->sum('total');
        $total_profit = ($total_sells - $total_purchases);


        $users = User::where('shop_id', auth()->user()->shop_id)->get();
        $due_lists = Invoice::where('status', 0)->where('shop_id', auth()->user()->shop_id)->get();

        return view('dashboard', compact('users', 'due_lists', 'todays_sells', 'this_month_sells', 'this_year_sells',  'total_sells', 'total_purchases', 'total_profit'));
    }
}
