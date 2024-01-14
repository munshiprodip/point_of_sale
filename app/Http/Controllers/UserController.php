<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;
use App\Models\Shop;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;


class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Read User', ['only' => ['index']]);
        $this->middleware('permission:Write User', ['only' => ['store']]);
        $this->middleware('permission:Modify User', ['only' => ['findById', 'update', 'changeStatus']]);
        $this->middleware('permission:Delete User', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $users = User::with('roles')->where('id', '!=', auth()->id());
        if($request->ajax()){
            return DataTables::of($users)->make(true);
        }
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        $shops = Shop::all();
        return view('admin.users.index', compact('roles', 'shops'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|unique:users',
            'password'      => 'required',
            'roles'         => 'required',
            'shop_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'shop_id' => $request->shop_id,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            $user->assignRole($request->roles);
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
    //Get user by id
    public function findById($id)
    {
        $user = User::with('roles')->where('id', $id)->first();
        $roles = $user->getRoleNames();
        if($user){
            return response()->json([
                'success'   => true,
                'user'      => $user,
                'roles'     => $roles,
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
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'email'         => 'required|unique:users,email,'.$user->id,
            'roles'         => 'required',
            'shop_id'         => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->shop_id = $request->shop_id;
        $user->save();

        $user->syncRoles($request->roles);
        
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }
    public function changeStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Status changed successfully'
        ]);
    }
    public function destroy($id)
    {
        User::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
