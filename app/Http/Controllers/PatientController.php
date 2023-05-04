<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;

class PatientController extends Controller
{
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $patient = Patient::findOrFail($id);
        $patient->nid               =  request('nid', NULL);
        $patient->phone             =  request('phone', NULL);
        $patient->name              =  request('name', NULL);
        $patient->father_name       =  request('father_name', NULL);
        $patient->mother_name       =  request('mother_name', NULL);
        $patient->dob               =  request('dob', NULL);
        $patient->occupation        =  request('occupation', NULL);
        $patient->bloodgroup        =  request('bloodgroup', NULL);
        $patient->marital_status    =  request('marital_status', NULL);
        $patient->religion          =  request('religion', NULL);
        $patient->spouse_name       =  request('spouse_name', NULL);
        $patient->gender            =  request('gender', NULL);
        $patient->nationality       =  request('nationality', NULL);
        $patient->email             =  request('email', NULL);
        $patient->present_address   =  request('present_address', NULL);
        $patient->permanent_address =  request('permanent_address', NULL);

        $saved = $patient->save();

        if(!$saved){
            return response()->json([
                'success'   => false,
                'type'      => 'error',
                'title'     => 'Error!',
                'message'   => 'Updated Failed',
            ]);
        }
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Saved successfully',
        ]);
    }
}
