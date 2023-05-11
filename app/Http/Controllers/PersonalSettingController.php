<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Hash;

class PersonalSettingController extends Controller
{
    public function organizationSetting ()
    {
        $personal_settings = auth()->user()->settings()->first();
        return view('settings.profiles.organization.index', compact('personal_settings'));
    }

    public function emrSetting ()
    {
        $personal_settings = auth()->user()->settings()->first();
        return view('settings.profiles.emr.index', compact('personal_settings'));
    }

    public function printSetting ()
    {
        $personal_settings = auth()->user()->settings()->first();
        return view('settings.profiles.print.index', compact('personal_settings'));
    }

    public function organizationSettingUpdate(Request $request)
    {
        $personal_settings = auth()->user()->settings()->first();
        

        if($request->hasFile('org_logo')){

            $validator = Validator::make($request->all(), [
                'org_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $validator->messages()->all()[0],
                ]);
            }

            $org_logo = $request->file('org_logo');
            $imageName = time() .'_'. $personal_settings->id . '.' . $org_logo->getClientOriginalExtension();

            $request->org_logo->move(public_path('images/logo'), $imageName);

            //delete old image
            if($personal_settings->org_logo != NULL){
                $old_image = public_path('images/logo/'.$personal_settings->org_logo);
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }

            $personal_settings->org_logo = $imageName;
            $personal_settings->save();
        }

        $personal_settings->org_title        = request('org_title', $personal_settings->org_title);
        $personal_settings->org_subtitle     = request('org_subtitle', $personal_settings->org_subtitle);
        $personal_settings->org_phone        = request('org_phone', $personal_settings->org_phone);
        $personal_settings->org_fax          = request('org_fax', $personal_settings->org_fax);
        $personal_settings->org_mail         = request('org_mail', $personal_settings->org_mail);
        $personal_settings->org_web          = request('org_web', $personal_settings->org_web);
        $personal_settings->org_address      = request('org_address', $personal_settings->org_address);

        
        $personal_settings->save();

        
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }

    public function emrSettingUpdate(Request $request)
    {
        $personal_settings = auth()->user()->settings()->first();
        

        if($request->hasFile('org_logo')){

            $validator = Validator::make($request->all(), [
                'org_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $validator->messages()->all()[0],
                ]);
            }

            $org_logo = $request->file('org_logo');
            $imageName = time() .'_'. $personal_settings->id . '.' . $org_logo->getClientOriginalExtension();

            $request->org_logo->move(public_path('images/logo'), $imageName);

            //delete old image
            if($personal_settings->org_logo != NULL){
                $old_image = public_path('images/logo/'.$personal_settings->org_logo);
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }

            $personal_settings->org_logo = $imageName;
            $personal_settings->save();
        }

        $personal_settings->prescription_patient_info_modal     =   request('prescription_patient_info_modal', 0);
        $personal_settings->prescription_vital_sign_modal       =   request('prescription_vital_sign_modal', 0);
        $personal_settings->prescription_allergy_modal          =   request('prescription_allergy_modal', 0);
        $personal_settings->prescription_past_history_modal     =   request('prescription_past_history_modal', 0);
        $personal_settings->prescription_gynae_obs_modal        =   request('prescription_gynae_obs_modal', 0);
        $personal_settings->prescription_child_history_modal    =   request('prescription_child_history_modal', 0);
        $personal_settings->prescription_chief_complaint_tab    =   request('prescription_chief_complaint_tab', 0);
        $personal_settings->prescription_case_summery_tab       =   request('prescription_case_summery_tab', 0);
        $personal_settings->prescription_drug_history_tab       =   request('prescription_drug_history_tab', 0);
        $personal_settings->prescription_on_examinition_tab     =   request('prescription_on_examinition_tab', 0);
        $personal_settings->prescription_investigation_tab      =   request('prescription_investigation_tab', 0);
        $personal_settings->prescription_diagnosis_tab          =   request('prescription_diagnosis_tab', 0);
        $personal_settings->prescription_procedure_tab          =   request('prescription_procedure_tab', 0);
        
        
        $personal_settings->save();

        
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }

    public function printSettingUpdate(Request $request)
    {
        $personal_settings = auth()->user()->settings()->first();
        

        if($request->hasFile('org_logo')){

            $validator = Validator::make($request->all(), [
                'org_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => $validator->messages()->all()[0],
                ]);
            }

            $org_logo = $request->file('org_logo');
            $imageName = time() .'_'. $personal_settings->id . '.' . $org_logo->getClientOriginalExtension();

            $request->org_logo->move(public_path('images/logo'), $imageName);

            //delete old image
            if($personal_settings->org_logo != NULL){
                $old_image = public_path('images/logo/'.$personal_settings->org_logo);
                if(file_exists($old_image)){
                    unlink($old_image);
                }
            }

            $personal_settings->org_logo = $imageName;
            $personal_settings->save();
        }

        $personal_settings->print_margin_top                    =   request('print_margin_top', $personal_settings->print_margin_top);
        $personal_settings->print_margin_bottom                 =   request('print_margin_bottom', $personal_settings->print_margin_bottom);
        $personal_settings->print_margin_left                   =   request('print_margin_left', $personal_settings->print_margin_left);
        $personal_settings->print_margin_right                  =   request('print_margin_right', $personal_settings->print_margin_right);
        $personal_settings->print_chief_complaint               =   request('print_chief_complaint', 0);
        $personal_settings->print_case_summery                  =   request('print_case_summery', 0);
        $personal_settings->print_on_examinition                =   request('print_on_examinition', 0);
        $personal_settings->print_investigation                 =   request('print_investigation', 0);
        $personal_settings->print_diagnosis                     =   request('print_diagnosis', 0);
        $personal_settings->print_advice                        =   request('print_advice', 0);
        $personal_settings->print_follow_up                     =   request('print_follow_up', 0);
        $personal_settings->print_signature                     =   request('print_signature', 0);
        $personal_settings->print_image                         =   request('print_image', 0);
       
        
        $personal_settings->save();

        
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }
}
