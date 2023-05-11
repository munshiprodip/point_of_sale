<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Read Permission', ['only' => ['index']]);
        $this->middleware('permission:Write Permission', ['only' => ['store']]);
        $this->middleware('permission:Modify Permission', ['only' => ['findById', 'update', 'changeStatus']]);
        $this->middleware('permission:Delete Permission', ['only' => ['destroy']]);
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        $permissions = Permission::with('roles');
        if($request->ajax()){
            return DataTables::of($permissions)->make(true);
        }
        return view('admin.permissions.index');
    }
    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'type'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $permission = Permission::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        if($permission){
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
        $permission = Permission::findOrFail($id);
        if($permission){
            return response()->json([
                'success'       => true,
                'permission'     => $permission,
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
        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'type'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $permission->name = $request->name;
        $permission->type = $request->type;
        $permission->save();
      
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
        $permission = Permission::findOrFail($id);
        $permission->status = !$permission->status;
        $permission->save();
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
        Permission::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}