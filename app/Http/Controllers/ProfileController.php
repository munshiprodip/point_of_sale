<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    public function account()
    {
        $bloodgroups = [
            0 => 'A(+ve)',
            1 => 'B(+ve)',
            2 => 'AB(+ve)',
            3 => 'O(+ve)',
            4 => 'A(-ve)',
            5 => 'B(-ve)',
            6 => 'AB(-ve)',
            7 => 'O(-ve)',         
        ];
        $genders = [
            0 => 'Male',
            1 => 'Female',
            2 => 'Others',
        ];
        return view('settings.profiles.account.index', compact('bloodgroups', 'genders'));
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            'email'                 => 'required|unique:users,email,'.$user->id,
            'nid'                   => 'required|unique:users,nid,'.$user->id,
            'phone'                 => 'required|unique:users,phone,'.$user->id,
            'present_address'       => 'required',
            'permanent_address'     => 'required',
            'dob'                   => 'required',
            'reg_no'                => 'required|unique:users,reg_no,'.$user->id,
            'religion'              => 'required',
            'nationality'           => 'required',
            'gender'                => 'required',
            'bloodgroup'            => 'required',
            'appointment_fee'       => 'required',
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
        $user->nid          = $request->nid;
        $user->phone        = $request->phone;
        $user->present_address = $request->present_address;
        $user->permanent_address = $request->permanent_address;
        $user->dob          = $request->dob;
        $user->reg_no       = $request->reg_no;
        $user->religion     = $request->religion;
        $user->nationality  = $request->nationality;
        $user->gender       = $request->gender;
        $user->bloodgroup   = $request->bloodgroup;
        $user->appointment_fee   = $request->appointment_fee;
        
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
        return view('settings.profiles.security.index');
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






    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
