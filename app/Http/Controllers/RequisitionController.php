<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Product;
use App\Models\RequisitionCart;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use DB;

class RequisitionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Requisitions', ['only' => ['list', 'details']]);
        $this->middleware('permission:Create Requisitions', ['only' => ['create', 'store']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $requisitions = Requisition::where('shop_id', auth()->user()->shop->id);
            return DataTables::of($requisitions)
            ->addColumn('items_count', function($row){
                return $row->requisition_items->count();
            })
            ->addColumn('date', function($row){
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->addColumn('prepared_by', function($row){
                return $row->createdBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('requisitions.list');
    }

    public function details($id)
    {
        $requisition = Requisition::findOrFail($id);
        $i=0;
        return view('requisitions.details', compact('requisition', 'i'));
    }

    public function create(Request $request)
    {
        if($request->ajax()){
            $cart_items = RequisitionCart::where('user_id', auth()->id());
            return DataTables::of($cart_items)
            ->addColumn('sku', function($row){
                return $row->product->sku;
            })
            ->addColumn('name', function($row){
                return $row->product->name;
            })
            ->addIndexColumn()
            ->make(true);
        }

        $products = Product::where('status', 1)->get();
        return view('requisitions.create', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'    => 'required',
            'quantity'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $cartExist = RequisitionCart::where('product_id', $request->product_id)->where('user_id', auth()->id())->first();

        if($cartExist){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => 'Allready exist in requisition list',
            ]);
        }

        $cart = RequisitionCart::create([
            'user_id'     => auth()->id(),
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
        ]);

        if($cart){
            return response()->json([
                'success'   => true,
                'type'      => 'success',
                'title'     => 'Success!',
                'message'   => 'Product added successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => "Product add failed",
            ]);
        }
        
    }

    public function deleteFromCart($id)
    {
        RequisitionCart::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Deleted successfully!!",
        ]);
    }

    public function prepare(Request $request)
    {
        $cart_items = RequisitionCart::where('user_id', auth()->id())->get();

       if($cart_items->isEmpty()){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message' => "No item in cart!!",
            ]);
       }else{
            DB::beginTransaction();
            
            try {
                $requisition_uid = IdGenerator::generate(['table' => 'requisitions', 'field' => 'requisition_uid', 'length' => 10, 'prefix' => 'R'.date('ym')]);
                $requisition = Requisition::create([
                    'requisition_uid'   => $requisition_uid,
                    'shop_id'           =>  auth()->user()->shop->id,
                    'created_by'        => auth()->id(),
                ]);
                foreach($cart_items as $cart_item){
                    RequisitionItem::create([
                        'requisition_id'    => $requisition->id,
                        'product_id'    => $cart_item->product_id,
                        'quantity'  => $cart_item->quantity,
                    ]);
                }
                RequisitionCart::where('user_id', auth()->id())->delete();
                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $e->errorInfo,
                ]);
            }

            return response()->json([
                'success'   => true,
                'type'      => 'success',
                'title'     => 'Success!',
                'message' => "Invoice created successfully!!",
            ]);
       }

    }
}
