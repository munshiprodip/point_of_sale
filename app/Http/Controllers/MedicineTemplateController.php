<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\MedicineTemplate;
use App\Models\TemplatedMedicine;
use App\Models\Medication;

class MedicineTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = MedicineTemplate::where('id', '>', 0);
        if($request->ajax()){
            return DataTables::of($templates)->addIndexColumn()->make(true);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required',
            'appointment_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $medicine_template = MedicineTemplate::create([
            'name'          => $request->name,
        ]);

        if($medicine_template){
            $medications = Medication::where('appointment_id', $request->appointment_id)->get();

            foreach($medications as $row){
                TemplatedMedicine::create([
                    'medicine_template_id' => $medicine_template->id,
                    'medicine'             => $row->medicine,
                    'dose'                 => $row->dose,
                    'instruction'          => $row->instruction,
                    'duration'             => $row->duration,
                    'note'                 => $row->note,
                ]);
            }

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

    public function addToAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medicine_template_id'  => 'required',
            'appointment_id'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $medicines = TemplatedMedicine::where('medicine_template_id', $request->medicine_template_id)->get();
        
        foreach($medicines as $row){
            Medication::create([
                'appointment_id'    => $request->appointment_id,
                'medicine'          => $row->medicine,
                'dose'              => $row->dose,
                'instruction'       => $row->instruction,
                'duration'          => $row->duration,
                'note'              => $row->note,
            ]);
        }
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Stored successfully',
        ]);

    }
}
