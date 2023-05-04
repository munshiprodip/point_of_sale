<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function store(Request $request, $appointment_id)
    {
        $validator = Validator::make($request->all(), [
            'medicine'      => 'required',
            'dose'          => 'required',
            'medicine'      => 'required',
            'instruction'   => 'required',
            'duration'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $medication = Medication::create([
            'appointment_id'    => $appointment_id,
            'medicine'          => $request->medicine,
            'dose'              => $request->dose,
            'instruction'       => $request->instruction,
            'duration'          => $request->duration,
            'note'              => $request->note,
        ]);

        if($medication){
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

    public function getMedication(Request $request, $appointment_id)
    {
        $medications = Medication::orderBy('id');
        if($request->ajax()){
            return DataTables::of($medications)->addIndexColumn()->make(true);
        }
    }

    public function destroy($id)
    {
        Medication::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}
