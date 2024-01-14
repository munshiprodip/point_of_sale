<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\InvoiceCart;
use App\Models\Stock;
use App\Models\Payment;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use DB;
use PDF;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:View Invoices', ['only' => ['list', 'details', 'dueList', 'print']]);
        $this->middleware('permission:Create Invoices', ['only' => ['create', 'addToCart', 'deleteFromCart', 'prepare', 'collectDue', 'makePayment']]);
    }

    public function list(Request $request)
    {
        if($request->ajax()){
            $invoices = Invoice::where('shop_id', auth()->user()->shop->id);
            return DataTables::of($invoices)
            ->addColumn('items_count', function($row){
                return $row->invoice_items->count();
            })
            ->addColumn('date', function($row){
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->addColumn('paid_status', function($row){
                return $row->status? 'Paid' : 'Due';
            })
            ->addColumn('sold_by', function($row){
                return $row->createdBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('invoices.list');
    }

    public function dueList(Request $request)
    {
        if($request->ajax()){
            $invoices = Invoice::where('shop_id', auth()->user()->shop->id)->where('status', 0);
            return DataTables::of($invoices)
            ->addColumn('items_count', function($row){
                return $row->invoice_items->count();
            })
            ->addColumn('date', function($row){
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->addColumn('due_amount', function($row){
                return number_format($row->total - $row->paid_amount, 2);
            })
            ->addColumn('sold_by', function($row){
                return $row->createdBy->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('invoices.due_list');
    }

    public function collectDue($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.collect_due', compact('invoice'));
    }

    public function makePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paid_amount'   => 'required',
            'invoice_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $invoice = Invoice::findOrFail($request->invoice_id);
        $payment_uid = IdGenerator::generate(['table' => 'payments', 'field' => 'payment_uid', 'length' => 10, 'prefix' => 'V'.date('ym')]);

        // If make payment create payment voucher
        $payment = Payment::create([
            'shop_id'       => $invoice->shop_id,
            'payment_uid'   => $payment_uid,
            'invoice_id'    => $invoice->id,
            'amount'        => $request->paid_amount,
            'received_by'   => auth()->id(),
        ]); 

        if($payment){
            $invoice->paid_amount += $request->paid_amount;
            if( $request->paid_amount >= ($invoice->total - $invoice->paid_amount)){
                $invoice->status = 1;
            }
            
            $invoice->save();
        }
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Payment received successfully!!",
        ]);

    }

    public function details($id)
    {
        $invoice = Invoice::findOrFail($id);
        $i=0;
        return view('invoices.details', compact('invoice', 'i'));
    }

    public function create(Request $request)
    {
        if($request->ajax()){
            $cart_items = InvoiceCart::where('user_id', auth()->id());
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

        //$products = Product::where('status', 1)->get();
        $products = Product::whereHas('stocks', function ($query){
            $query->where('shop_id', auth()->user()->shop->id)
                  ->where('quantity', '>', 0);
        })->get();

        //dd($products);

        return view('invoices.create', compact('products'));
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

        $cartExist = InvoiceCart::where('product_id', $request->product_id)->where('user_id', auth()->id())->first();
        
        if($cartExist){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => 'Allready exist in cart list',
            ]);
        }
        $product = Product::findOrFail($request->product_id);
        if($request->quantity > $product->stockQty(auth()->user()->shop_id)){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => "Quantity cann't be grater than stock quantity",
            ]);
        }

        $cart = InvoiceCart::create([
            'user_id'     => auth()->id(),
            'product_id'  => $product->id,
            'unit_price'  => $product->sale_price,
            'quantity'    => $request->quantity,
            'total_price' => $request->quantity * $product->sale_price,
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
        InvoiceCart::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Deleted successfully!!",
        ]);
    }


    public function prepare(Request $request)
    {
        // Check cart item, if empty return with message
        // Start database transactions
        // Generate Invoice unique ID
        // Create Invoice
        // Create Invoice Items and adjust stock
        // Remove product from cart
        // Generate payment unique ID
        // If make payment create payment voucher
        // Save all database transaction
        // If get error roll back all database transactions
        // Return success message


        // Check cart item, if empty return with message
        $cart_items = InvoiceCart::where('user_id', auth()->id())->get();
        if($cart_items->isEmpty()){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message' => "No item in cart!!",
            ]);
        }else{
            // Start database transactions
            DB::beginTransaction();
            
            try {
                // Generate Invoice unique ID
                $invoice_uid = IdGenerator::generate(['table' => 'invoices', 'field' => 'invoice_uid', 'length' => 10, 'prefix' => 'I'.date('ym')]);
                
                $paid_amount = 0;
                $payment_status = 0;

                if($request->cash_given >= $request->grand_total){
                    $paid_amount = $request->grand_total;
                    $payment_status = 1;
                }elseif($request->cash_given > 0){
                    $paid_amount = $request->cash_given;
                }
                // Create Invoice
                $invoice = Invoice::create([
                    'invoice_uid'       => $invoice_uid,
                    'shop_id'           => auth()->user()->shop->id,
                    'customer_name'     => $request->customer_name,
                    'customer_address'  => $request->customer_address,
                    'customer_phone'    => $request->customer_phone,
                    'sub_total'         => $request->sub_total,
                    'discount'          => $request->discount,
                    'total'             => $request->grand_total,
                    'paid_amount'       => $paid_amount,
                    'status'            => $payment_status,
                    'created_by'        => auth()->id(),
                ]);
                // Create Invoice Items and adjust stock
                foreach($cart_items as $cart_item){
                    $invoice_item = InvoiceItem::create([
                        'invoice_id'    => $invoice->id,
                        'product_id'    => $cart_item->product_id,
                        'unit_price'    => $cart_item->unit_price,
                        'quantity'      => $cart_item->quantity,
                        'total_price'   => $cart_item->total_price,
                        'created_by'        => auth()->id(),
                    ]);

                    $stock = Stock::where('shop_id', $invoice->shop_id)->where('product_id', $invoice_item->product_id)->first();
                    
                    $stock->quantity    -= $invoice_item->quantity;
                    $stock->updated_by  = auth()->id();
                    $stock->save();
                    
                }
                // Remove product from cart
                InvoiceCart::where('user_id', auth()->id())->delete();
            
                // Generate payment unique ID
                $payment_uid = IdGenerator::generate(['table' => 'payments', 'field' => 'payment_uid', 'length' => 10, 'prefix' => 'V'.date('ym')]);

                // If make payment create payment voucher
                if($paid_amount){
                    Payment::create([
                        'shop_id'       => $invoice->shop_id,
                        'payment_uid'   => $payment_uid,
                        'invoice_id'    => $invoice->id,
                        'amount'        => $paid_amount,
                        'received_by'   => auth()->id(),
                    ]); 
                }
                // Save all database transaction
                DB::commit();

            } catch (\Exception $e) {
                // If get error roll back all database transactions
                DB::rollBack();
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $e->errorInfo,
                ]);
            }

            return response()->json([
                'success'       => true,
                'type'          => 'success',
                'title'         => 'Success!',
                'message'       => "Invoice created successfully!!",
                'invoice_id'    => $invoice->id,
            ]);
        }

    }

    public function print($id)
    {
        $order = Invoice::findOrFail($id); 
        $customPaper = array(0,0,650.00,226.00);

        $pdf = PDF::loadView('invoices.pos_print', compact('order'))->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }
}
