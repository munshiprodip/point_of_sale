<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shop;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Shop Settings', ['only' => ['settings', 'updateSettings']]);
    }

    public function settings(Request $request)
    {
        $shop = auth()->user()->shop;
        return view('shops.settings', compact('shop'));
    }

    public function updateSettings(Request $request)
    {
        $shop = auth()->user()->shop;
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'header_text'   => 'required',
            'footer_text'   => 'required',
            'vat'           => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $shop->name         = $request->name;
        $shop->address      = $request->address;
        $shop->website      = $request->website;
        $shop->phone        = $request->phone;
        $shop->email        = $request->email;
        $shop->header_text  = $request->header_text;
        $shop->footer_text  = $request->footer_text;
        $shop->vat          = $request->vat;

        $shop->updated_by   = auth()->id();
        $shop->save();
      
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }
}
