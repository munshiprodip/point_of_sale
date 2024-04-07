<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Products', ['only' => ['list']]);
        $this->middleware('permission:Create Products', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Products', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Products', ['only' => ['destroy']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $products = Product::where('id', '>', 0);
            return DataTables::of($products)
            ->addColumn('stock_quantity', function($row){
                return $row->stockQty(auth()->user()->shop->id). ' '. $row->uom;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('products.list');
    }

    public function create()
    {
        return view('products.create');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'purchase_price'    => 'required',
            'sale_price'        => 'required',
            'uom'               => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $sku = IdGenerator::generate(['table' => 'products', 'field' => 'sku', 'length' => 6, 'prefix' => 'E']);

        $product = Product::create([
            'name'              => $request->name,
            'sku'               => $sku,
            'purchase_price'    => $request->purchase_price,
            'sale_price'        => $request->sale_price,
            'uom'               => $request->uom,
            'created_by' => auth()->id(),
        ]);

        if($product){
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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'purchase_price'    => 'required',
            'sale_price'        => 'required',
            'uom'               => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $product = Product::findOrFail($id);
        
        $product->name             = $request->name;
        $product->purchase_price   = $request->purchase_price;
        $product->sale_price       = $request->sale_price;
        $product->uom              = $request->uom;
        $product->updated_by       = auth()->id();
        $product->save();
       

        if($product){
            return response()->json([
                'success'   => true,
                'type'      => 'success',
                'title'     => 'Success!',
                'message'   => 'Update successfully',
            ]);
        }else{
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => "Update failed",
            ]);
        }
        
    }

    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Deleted successfully!!",
        ]);
    }

}
