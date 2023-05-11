<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Read Role', ['only' => ['index']]);
        $this->middleware('permission:Write Role', ['only' => ['store']]);
        $this->middleware('permission:Modify Role', ['only' => ['findById', 'update', 'changeStatus']]);
        $this->middleware('permission:Delete Role', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $roles = Role::with('users');
        if($request->ajax()){
            return DataTables::of($roles)->make(true);
        }

        $permissions = Permission::all()->groupBy('type');
        return view('admin.roles.index', compact('permissions'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $role = Role::create([
            'name' => $request->name,
        ]);

        if($role){
            $role->syncPermissions($request->permissions);
            
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
    //Get ermission by id
    public function findById($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions->pluck('name');

        if($role){
            return response()->json([
                'success'       => true,
                'role'          => $role,
                'permissions'   => $permissions,
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
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);
      
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }
    public function changeStatus($id)
    {
        $role = Role::findOrFail($id);
        $role->status = !$role->status;
        $role->save();
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Status changed successfully'
        ]);
    }
    public function destroy($id)
    {
        Role::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
