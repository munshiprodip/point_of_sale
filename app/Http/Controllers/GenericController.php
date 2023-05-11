<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Generic;

class GenericController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Medication Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        $generics = Generic::orderBy('name', 'asc');
        if($request->ajax()){
            return DataTables::of($generics)->addIndexColumn()->make(true);
        }
        return view('settings.medications.generics.index');
    }
    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $generic = Generic::create([
            'name' => $request->name,
            'created_by' => auth()->id(),
        ]);

        if($generic){
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
        $generic = Generic::findOrFail($id);
        if($generic){
            return response()->json([
                'success'       => true,
                'data'     => $generic,
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
        $generic = Generic::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $generic->name = $request->name;
        $generic->save();
      
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
        $generic = Generic::findOrFail($id);
        $generic->status = !$generic->status;
        $generic->save();
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
        Generic::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
