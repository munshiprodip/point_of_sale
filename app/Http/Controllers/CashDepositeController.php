<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashDeposite;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class CashDepositeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Create Cash Deposite', ['only' => ['store']]);
        $this->middleware('permission:Cash Receive', ['only' => ['verify']]);
        $this->middleware('permission:View Deposits History', ['only' => ['verified']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $cash_deposites = CashDeposite::where('status', 0);
            return DataTables::of($cash_deposites)
            ->addColumn('user_name', function($row){
                return $row->createdBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }

        return view('cash_deposites.list');
    }

    public function verified(Request $request)
    {
        if($request->ajax()){
            $cash_deposites = CashDeposite::where('status', 1);
            return DataTables::of($cash_deposites)
            ->addColumn('user_name', function($row){
                return $row->createdBy->name;
            })
            ->addColumn('receiver_name', function($row){
                return $row->receivedBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('cash_deposites.verified');
    }

    public function verify(Request $request)
    {
        $cash_deposite = CashDeposite::findOrFail($request->id);
        $cash_deposite->status = 1;
        $cash_deposite->received_by = auth()->id();
        $cash_deposite->save();

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Received successfully'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description'        => 'required',
            'amount'             => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $cash_deposite = CashDeposite::create([
            'description'   => $request->description,
            'amount'        => $request->amount,
            'created_by'    => auth()->id(),
        ]);

        if($cash_deposite){
            return response()->json([
                'success'   => true,
                'type'      => 'success',
                'title'     => 'Success!',
                'message'   => 'Deposite request successfull',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => "Deposite failed",
            ]);
        }
        
    }
}
