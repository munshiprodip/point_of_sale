<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Medication;
use App\Models\FavouriteMedication;
use App\Models\Appointment;

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

    public function storeFavouriteMedication(Request $request)
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

        $favourite_medication = FavouriteMedication::create([
            'medicine'          => $request->medicine,
            'dose'              => $request->dose,
            'instruction'       => $request->instruction,
            'duration'          => $request->duration,
            'note'              => $request->note,
            'created_by'        => auth()->id(),
        ]);

        if($favourite_medication){
            return response()->json([
                'success'   => false,
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
        $medications = Medication::where('appointment_id', $appointment_id);
        if($request->ajax()){
            return DataTables::of($medications)->addIndexColumn()->make(true);
        }
    }

    public function getPreviousMedication(Request $request, $appointment_id)
    {
        $patient = Appointment::findOrFail($appointment_id)->patient;
        $appointmentIds = $patient->appointments()->pluck('id')->toArray();
        $medications = Medication::whereIn('appointment_id', $appointmentIds)->whereNot('appointment_id', $appointment_id);
        if($request->ajax()){
            return DataTables::of($medications)->addIndexColumn()->make(true);
        }
    }

    public function getFavouriteMedication(Request $request)
    {
        $medications = FavouriteMedication::where('created_by', auth()->id());
        if($request->ajax()){
            return DataTables::of($medications)->addIndexColumn()->make(true);
        }
    }

    public function addFavouriteToAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'favourite_medication_id'  => 'required',
            'appointment_id'           => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $favourite_medication = FavouriteMedication::findOrFail($request->favourite_medication_id);
        
        $medication = Medication::create([
            'appointment_id'    => $request->appointment_id,
            'medicine'          => $favourite_medication->medicine,
            'dose'              => $favourite_medication->dose,
            'instruction'       => $favourite_medication->instruction,
            'duration'          => $favourite_medication->duration,
            'note'              => $favourite_medication->note,
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
