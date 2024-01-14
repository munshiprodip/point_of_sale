<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DamageItem;
use App\Models\Product;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;


class DamageItemController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Damages', ['only' => ['list', 'verified', 'canceled']]);
        $this->middleware('permission:Create Damages', ['only' => ['store']]);
        $this->middleware('permission:Verify Damages', ['only' => ['verify', 'cancel']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $damages = DamageItem::where('status', 0);
            return DataTables::of($damages)
            ->addColumn('product_sku', function($row){
                return $row->product->sku;
            })
            ->addColumn('product_name', function($row){
                return $row->product->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        $products = Product::whereHas('stocks', function ($query){
            $query->where('shop_id', auth()->user()->shop->id)
                  ->where('quantity', '>', 0);
        })->get();

        return view('damages.list', compact('products'));
    }

    public function verified(Request $request)
    {
        if($request->ajax()){
            $damages = DamageItem::where('status', 1);
            return DataTables::of($damages)
            ->addColumn('product_sku', function($row){
                return $row->product->sku;
            })
            ->addColumn('product_name', function($row){
                return $row->product->name;
            })
            ->addColumn('verifiedBy', function($row){
                return $row->verifiedBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('damages.verified');
    }

    public function canceled(Request $request)
    {
        if($request->ajax()){
            $damages = DamageItem::where('status', 2);
            return DataTables::of($damages)
            ->addColumn('product_sku', function($row){
                return $row->product->sku;
            })
            ->addColumn('product_name', function($row){
                return $row->product->name;
            })
            ->addColumn('verifiedBy', function($row){
                return $row->verifiedBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('damages.canceled');
    }


    public function verify(Request $request)
    {

        $damage = DamageItem::findOrFail($request->id);
        $stock = Stock::where('shop_id', $damage->shop_id)->where('product_id', $damage->product_id)->first();

        $damage->status = 1;
        $damage->verified_by = auth()->id();
        $damage->save();

        $stock->quantity    -= $damage->quantity;
        $stock->updated_by  = auth()->id();
        $stock->save();

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Verified successfully'
        ]);
    }

    public function cancel(Request $request)
    {
        $damage = DamageItem::findOrFail($request->id);

        $damage->status = 2;
        $damage->verified_by = auth()->id();
        $damage->save();

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Canceled successfully'
        ]);
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'        => 'required',
            'quantity'          => 'required',
            'comment'           => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $damage = DamageItem::create([
            'shop_id'       => auth()->user()->shop_id,
            'product_id'    => $request->product_id,
            'quantity'      => $request->quantity,
            'comment'       => $request->comment,
            'created_by'    => auth()->id(),
        ]);

        if($damage){
            return response()->json([
                'success'   => true,
                'type'      => 'success',
                'title'     => 'Success!',
                'message'   => 'Stored successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => "Store failed",
            ]);
        }
        
    }
}
