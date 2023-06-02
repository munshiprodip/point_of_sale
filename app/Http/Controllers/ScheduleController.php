<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    function __construct()
    {
        //$this->middleware('permission:Medication Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        if($request->ajax()){
            $schedules = Schedule::where('organization_id', auth()->user()->organization_id);
            return DataTables::of($schedules)->addIndexColumn()->make(true);
        }
        return view('schedules.index');
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'start_time'          => 'required',
            'end_time'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $schedule = Schedule::create([
            'name'              => $request->name,
            'start_time'        => Carbon::parse($request->start_time)->format('H:i:s'),
            'end_time'          => Carbon::parse($request->end_time)->format('H:i:s'),
            'organization_id'   => auth()->user()->organization_id,
            'created_by' => auth()->id(),
        ]);

        if($schedule){
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
        $schedule = Schedule::findOrFail($id);
        if($schedule){
            return response()->json([
                'success'       => true,
                'data'     => $schedule,
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
        $schedule = Schedule::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'start_time'          => 'required',
            'end_time'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $schedule->name = $request->name;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->save();
      
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
        $schedule = Schedule::findOrFail($id);
        $schedule->status = !$schedule->status;
        $schedule->save();
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
        Schedule::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
