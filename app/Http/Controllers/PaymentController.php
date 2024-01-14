<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PaymentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Invoices', ['only' => ['list', 'details']]);
        $this->middleware('permission:Create Invoices', ['only' => ['create', 'addToCart', 'deleteFromCart', 'prepare']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $payments = Payment::where('shop_id', auth()->user()->shop->id);
            return DataTables::of($payments)
            ->addColumn('date', function($row){
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->addColumn('received_by', function($row){
                return $row->receivedBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('payments.list');
    }
}
