<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Duration;

class DurationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Medication Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        $durations = Duration::where('id', '>', 0);
        if($request->ajax()){
            return DataTables::of($durations)->addIndexColumn()->make(true);
        }
        return view('settings.medications.durations.index');
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'          => 'required',
            'name_bn'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $duration = Duration::create([
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'created_by' => auth()->id(),
        ]);

        if($duration){
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
        $duration = Duration::findOrFail($id);
        if($duration){
            return response()->json([
                'success'       => true,
                'data'     => $duration,
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
        $duration = Duration::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name_en'          => 'required',
            'name_bn'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $duration->name_en = $request->name_en;
        $duration->name_bn = $request->name_bn;
        $duration->save();
      
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
        $duration = Duration::findOrFail($id);
        $duration->status = !$duration->status;
        $duration->save();
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
        Duration::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
