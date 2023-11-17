<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Organization;

class OrganizationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Organization Setting', ['only' => ['index', 'store', 'findById', 'update', 'changeStatus', 'destroy']]);
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        if($request->ajax()){
            $organizations = Organization::where('id', '>', 0);
            return DataTables::of($organizations)->addIndexColumn()->make(true);
        }
        return view('organizations.index');
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'flex_time'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $organization = Organization::create([
            'name'          => $request->name,
            'flex_time'     => $request->flex_time,
            'created_by'    => auth()->id(),
        ]);

        if($organization){
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
        $organization = Organization::findOrFail($id);
        if($organization){
            return response()->json([
                'success'       => true,
                'data'     => $organization,
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
        $organization = Organization::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'flex_time'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $organization->name         = $request->name;
        $organization->flex_time    = $request->flex_time;
        $organization->save();
      
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
        $organization = Organization::findOrFail($id);
        $organization->status = !$organization->status;
        $organization->save();
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
        Organization::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }


    public function settings()
    {
        $organization = auth()->user()->organization;
        return view('organizations.settings', compact('organization'));
    }

    public function settingsSave(Request $request)
    {
        $organization = auth()->user()->organization;
        $validator = Validator::make($request->all(), [
            'name'                    => 'required',
            'founder'                 => 'required',
            'address'                 => 'required',
            'flex_time'               => 'required',
            'notification_status'     => 'required',
            'is_track_lunch'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $organization->name                   = $request->name;
        $organization->founder                = $request->founder;
        $organization->address                = $request->address;
        $organization->flex_time              = $request->flex_time;
        $organization->notification_status    = $request->notification_status;
        $organization->is_track_lunch         = $request->is_track_lunch;
        $organization->save();
      
        return redirect()->route('organizations.settings');
    }
}
