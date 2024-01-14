<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\PurchaseCart;
use App\Models\Stock;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use DB;

class PurchaseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Purchases', ['only' => ['list', 'details']]);
        $this->middleware('permission:Create Purchases', ['only' => ['create', 'addToCart', 'deleteFromCart', 'prepare']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $purchases = Purchase::where('shop_id', auth()->user()->shop->id);
            return DataTables::of($purchases)
            ->addColumn('items_count', function($row){
                return $row->purchase_items->count();
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
        return view('purchases.list');
    }

    public function details($id)
    {
        $purchase = Purchase::findOrFail($id);
        $i=0;
        return view('purchases.details', compact('purchase', 'i'));
    }

    public function create(Request $request)
    {
        if($request->ajax()){
            $cart_items = PurchaseCart::where('user_id', auth()->id());
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
        return view('purchases.create', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'    => 'required',
            'quantity'      => 'required',
            'unit_price'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $cartExist = PurchaseCart::where('product_id', $request->product_id)->where('user_id', auth()->id())->first();

        if($cartExist){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => 'Allready exist in purchase list',
            ]);
        }

        $cart = PurchaseCart::create([
            'user_id'     => auth()->id(),
            'product_id'  => $request->product_id,
            'unit_price'  => $request->unit_price,
            'quantity'    => $request->quantity,
            'total_price' => $request->quantity * $request->unit_price,
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
        PurchaseCart::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Deleted successfully!!",
        ]);
    }

    public function prepare(Request $request)
    {
        $cart_items = PurchaseCart::where('user_id', auth()->id())->get();

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
                $purchase_uid = IdGenerator::generate(['table' => 'purchases', 'field' => 'purchase_uid', 'length' => 10, 'prefix' => 'P'.date('ym')]);
                $purchase = Purchase::create([
                    'purchase_uid'   => $purchase_uid,
                    'shop_id'           =>  auth()->user()->shop->id,
                    'created_by'        => auth()->id(),
                ]);
                $subtotal = 0;

                foreach($cart_items as $cart_item){
                    
                    $purchase_item = PurchaseItem::create([
                        'purchase_id'   => $purchase->id,
                        'product_id'    => $cart_item->product_id,
                        'unit_price'    => $cart_item->unit_price,
                        'quantity'      => $cart_item->quantity,
                        'total_price'   => $cart_item->total_price,
                    ]);

                    $product = Product::findOrFail($purchase_item->product_id);
                    $product->purchase_price = $purchase_item->unit_price;
                    $product->save();


                    $subtotal += $purchase_item->total_price;
                    
                    $stock = Stock::where('shop_id', $purchase->shop_id)->where('product_id', $purchase_item->product_id)->first();
                    if($stock){
                        $stock->quantity    += $purchase_item->quantity;
                        $stock->updated_by  = auth()->id();
                        $stock->save();
                    }else{
                        Stock::create([
                            'shop_id'      => $purchase->shop_id,
                            'product_id'   => $purchase_item->product_id,
                            'quantity'     => $purchase_item->quantity,
                            'updated_by'   => auth()->id(),
                        ]);
                    }

                }

                $purchase->subtotal = $subtotal;
                $purchase->total = $subtotal;
                $purchase->save();

                PurchaseCart::where('user_id', auth()->id())->delete();
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
                'message' => "Purchase successfully!!",
            ]);
       }

    }
}

