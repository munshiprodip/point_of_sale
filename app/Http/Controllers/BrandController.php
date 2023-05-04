<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Brand;
use App\Models\Generic;
use App\Models\Company;

class BrandController extends Controller
{
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        $brands = Brand::where('id', '!=', '0');
        if($request->ajax()){
            return DataTables::of($brands)
            ->addColumn('generic', function($row){return $row->generic?->name;})
            ->addColumn('company', function($row){return $row->company?->name;})
            ->addIndexColumn()
            ->make(true);
        }

        $generics   = Generic::where('status', 1)->get();
        $companies  = Company::where('status', 1)->get();
        return view('settings.medications.brands.index', compact('generics', 'companies'));
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'generic_id'        => 'required',
            'company_id'        => 'required',
            'type'              => 'required',
            'strength'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $brand = Brand::create([
            'name'          => $request->name,
            'generic_id'    => $request->generic_id,
            'company_id'    => $request->company_id,
            'type'          => $request->type,
            'strength'      => $request->strength,
            'created_by'    => auth()->id(),
        ]);

        if($brand){
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

    //Find the specified resource in storage & return json response
    public function findById($id)
    {
        $brand = Brand::findOrFail($id);
        if($brand){
            return response()->json([
                'success'       => true,
                'data'     => $brand,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => "Data not found.",
            ]);
        }
    }

    //Update the specified resource in storage & return json response
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'generic_id'        => 'required',
            'company_id'        => 'required',
            'type'              => 'required',
            'strength'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $brand->name        = $request->name;
        $brand->generic_id  = $request->generic_id;
        $brand->company_id  = $request->company_id;
        $brand->type        = $request->type;
        $brand->strength    = $request->strength;
        $brand->save();
      
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }

    //Change the current status of specified resource from storage & return json response.
    public function changeStatus($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = !$brand->status;
        $brand->save();
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Status changed successfully'
        ]);
    }

    //Remove the specified resource from storage & return json response.
    public function destroy($id)
    {
        Brand::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
