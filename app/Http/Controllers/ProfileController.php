<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    public function account()
    {
        return view('profiles.account.index');
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'email'                 => 'required|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        if($request->hasFile('avater')){

            $validator = Validator::make($request->all(), [
                'avater' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $validator->messages()->all()[0],
                ]);
            }

            $avater = $request->file('avater');
            $imageName = time() .'_'. $user->id . '.' . $avater->getClientOriginalExtension();

            $request->avater->move(public_path('avaters'), $imageName);

            //delete old image
            if($user->avater != NULL){
                $old_image = public_path('avaters/'.$user->avater);
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }

            $user->avater = $imageName;
            $user->save();
        }

        $user->name         = $request->name;
        $user->email        = $request->email;
        
        $user->save();

        
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }



    public function security()
    {
        return view('profiles.security.index');
    }

    public function updateSecurity(Request $request)
    {
        $user = auth()->user();
        if (Hash::check($request->currentPassword, $user->password)) {
            $validator = Validator::make($request->all(), [
                'newPassword' => 'required|string|min:8',
                'confirmPassword' => 'required|string|min:8|same:newPassword'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $validator->messages()->all()[0],
                ]);
            }

            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()->json([
                'success'   => true,
                'type'      => 'success',
                'title'     => 'Success!',
                'message' => "Password updated successfully",
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message' => "Incorrect password!",
            ]);
        }

    }

}
