<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Brand;
use App\Models\Dose;
use App\Models\Instruction;
use App\Models\Duration;
use App\Models\ClinicalComponent;
use App\Models\PersonalSetting;
use DB;
use PDF;

use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::where('created_by', auth()->id());
        if($request->ajax()){
            return DataTables::of($appointments)
            ->addColumn('registration_no', function($row){
                return $row->patient->registration_no;
            })
            ->addColumn('name', function($row){
                return $row->patient->name;
            })
            ->addColumn('phone', function($row){
                return $row->patient->phone;
            })
            ->addColumn('date', function($row){
                return Carbon::parse($row->created_at);
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('patients.appointments.index', compact('appointments'));
    }

    public function todaysAppointment(Request $request)
    {
        return view('patients.appointments.index');
    }

    public function create()
    {
        return view('patients.appointments.create');
    }

    public function store(Request $request)
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

        $patient = Patient::where('phone', request('phone'))->first();
        if(!$patient){
            $patient = Patient::create([
                'registration_no'   => $this->generateUniqueId('patients', 'registration_no', 'R'),
                'nid'               => request('nid', NULL),
                'dob'               => request('dob', NULL),
                'name'              => request('name'),
                'father_name'       => request('father_name', NULL),
                'mother_name'       => request('mother_name', NULL),
                'marital_status'    => request('marital_status', NULL),
                'spouse_name'       => request('spouse_name', NULL),
                'gender'            => request('gender', NULL),
                'religion'          => request('religion', NULL),
                'nationality'       => request('nationality', NULL),
                'phone'             => request('phone'),
                'email'             => request('email', NULL),
                'occupation'        => request('occupation', NULL),
                'bloodgroup'        => request('bloodgroup', NULL),
                'present_address'   => request('present_address', NULL),
                'permanent_address' => request('permanent_address', NULL),
                'created_by'        => auth()->id(),
            ]);
        }

        if(!$patient->id){
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => "Patient registration failed!",
            ]);
        }

        $appointment = Appointment::create([
            'appointment_no'    => $this->generateUniqueId('appointments', 'appointment_no', 'C'),
            'patient_id'        => $patient->id,
            'pulse_rate'        => request('pulse_rate', NULL),
            'sao2'              => request('sao2', NULL),
            'respiratory_rate'  => request('respiratory_rate', NULL),
            'bp_systolic'       => request('bp_systolic', NULL),
            'bp_diastolic'      => request('bp_diastolic', NULL),
            'temperature'       => request('temperature', NULL),
            'height'            => request('height', NULL),
            'weight'            => request('weight', NULL),
            'bmi'               => request('bmi', NULL),
            'ofc'               => request('ofc', NULL),
            'created_by'        => request('doctor_id', auth()->id()),
        ]);

        if(!$appointment->id){
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => $patient->registration_no." - Registered but not appointed!",
            ]);
        }

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'appointment_no' => $appointment->appointment_no,
            'message'   => 'Appointment created successfully',
        ]);

    }


    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $appointment->anaemia               =   request('anaemia', $appointment->anaemia);
        $appointment->jaundice              =   request('jaundice', $appointment->jaundice);
        $appointment->cyanosis              =   request('cyanosis', $appointment->cyanosis);
        $appointment->oedema                =   request('oedema', $appointment->oedema);
        $appointment->dehydration           =   request('dehydration', $appointment->dehydration);
        $appointment->pulse_rate            =   request('pulse_rate', $appointment->pulse_rate);
        $appointment->sao2                  =   request('sao2', $appointment->sao2);
        $appointment->respiratory_rate      =   request('respiratory_rate', $appointment->respiratory_rate);
        $appointment->bp_systolic           =   request('bp_systolic', $appointment->bp_systolic);
        $appointment->bp_diastolic          =   request('bp_diastolic', $appointment->bp_diastolic);
        $appointment->temperature           =   request('temperature', $appointment->temperature);
        $appointment->height                =   request('height', $appointment->height);
        $appointment->weight                =   request('weight', $appointment->weight);
        $appointment->bmi                   =   request('bmi', $appointment->bmi);
        $appointment->rr                    =   request('rr', $appointment->rr);
        $appointment->ofc                   =   request('ofc', $appointment->ofc);
        $appointment->bsa                   =   request('bsa', $appointment->bsa);
        $appointment->us_ratio              =   request('us_ratio', $appointment->us_ratio);
        $appointment->ls_ratio              =   request('ls_ratio', $appointment->ls_ratio);
        $appointment->other_oe              =   request('other_oe', $appointment->other_oe);
        $appointment->chief_complaints      =   request('chief_complaints', $appointment->chief_complaints);
        $appointment->case_summary          =   request('case_summary', $appointment->case_summary);
        $appointment->on_examination        =   request('on_examination', $appointment->on_examination);
        $appointment->past_medical_history  =   request('past_medical_history', $appointment->past_medical_history);
        $appointment->past_surgical_history =   request('past_surgical_history', $appointment->past_surgical_history);
        $appointment->past_personal_history =   request('past_personal_history', $appointment->past_personal_history);
        $appointment->past_family_history   =   request('past_family_history', $appointment->past_family_history);
        $appointment->past_drug_history     =   request('past_drug_history', $appointment->past_drug_history);
        $appointment->allergy_history       =   request('allergy_history', $appointment->allergy_history);
        $appointment->food_allergy          =   request('food_allergy', $appointment->food_allergy);
        $appointment->drug_allergy          =   request('drug_allergy', $appointment->drug_allergy);
        $appointment->other_allergy         =   request('other_allergy', $appointment->other_allergy);
        $appointment->cardiovascular_system =   request('cardiovascular_system', $appointment->cardiovascular_system);
        $appointment->respiratory_system    =   request('respiratory_system', $appointment->respiratory_system);
        $appointment->abdominal_system      =   request('abdominal_system', $appointment->abdominal_system);
        $appointment->genito_urinary_system =   request('genito_urinary_system', $appointment->genito_urinary_system);
        $appointment->locomotor_system      =   request('locomotor_system', $appointment->locomotor_system);
        $appointment->nervous_system        =   request('nervous_system', $appointment->nervous_system);
        $appointment->others_system         =   request('others_system', $appointment->others_system);
        $appointment->investigations        =   request('investigations', $appointment->investigations);
        $appointment->diagnosis             =   request('diagnosis', $appointment->diagnosis);
        $appointment->procedure             =   request('procedure', $appointment->procedure);
        $appointment->advice                =   request('advice', $appointment->advice);
        $appointment->follow_up             =   request('follow_up', $appointment->follow_up);
        $appointment->next_visit            =   request('next_visit', $appointment->next_visit);
        $appointment->image                 =   request('image', $appointment->image);

        $saved = $appointment->save();

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

    public function prescribe($appointment_no)
    {
        $appointment = Appointment::with('patient')->where('appointment_no', $appointment_no)->first();

        if($appointment?->created_by == auth()->id()){
            // return $appointment;
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
            $religions = [
                0 => 'Muslim',
                1 => 'Hindu',
            ];
            $marital_status = [
                0 => 'Married',
                1 => 'Unmarried',
            ];
            $examination_values = [
                0 => '(-)',
                1 => '(+)',
                2 => '(++)',
                3 => '(+++)',        
            ];
            $brands      = Brand::with('generic')->get();
            //$brands      = Brand::all();
            $doses          = Dose::all();
            $instructions   = Instruction::all();
            $durations      = Duration::all();

            $ageText  = $this->calculateAge($appointment->patient->dob);
            return view('patients.appointments.prescribe', compact('appointment', 'bloodgroups', 'genders', 'religions', 'marital_status', 'ageText', 'examination_values', 'brands', 'doses', 'instructions', 'durations'));
        }else{
            return response()->json([
                'messege' => "Incorrect appointment number",
            ]);
        }
        
        
    }

    public function previousAppointments(Request $request, $patient_id, $appointment_no)
    {
        $appointments = Appointment::where('patient_id', $patient_id)->where('appointment_no', '!=', $appointment_no)->get();
        if($request->ajax()){
            return DataTables::of($appointments)->addIndexColumn()->make(true);
        }
    }

    public function registration()
    {
        return view('patients.appointments.registration');
    }

    //Print prescription
    public function generatePrescription($appointment_id)
    {
        $settings = PersonalSetting::where('created_by', auth()->id())->first();
        $appointment = Appointment::find($appointment_id);
        //$pdf = PDF::loadView('patients.prescriptions.index', compact('appointment'));
        //return $pdf->stream($appointment->id.'.pdf');
        return view('patients.prescriptions.index', compact('appointment', 'settings'));
    }







    public function generateUniqueId($table, $column, $prefix){

        // Get the current year and month
        $year = date('Y');
        $month = date('m');

        // Generate the base prefix
        $prefix = $prefix . $year . $month;

        // Get the maximum ID from the database for the current year and month
        $maxId = DB::table($table)->where($column, 'like', $prefix . '%')->max('id');

        // Convert the maxId to integer and increment by 1
        $newNumericPart = intval($maxId) + 1;

        // Pad the new numeric part with leading zeros to get 6 digits
        $newNumericPart = str_pad($newNumericPart, 6, '0', STR_PAD_LEFT);

        // Concatenate the base prefix with the new numeric part to get the unique ID
        $newId = $prefix . $newNumericPart;

        // Return newId
        return $newId;
    }


    function calculateAge($birthdate) {
        // Create Carbon instance for birthdate
        $dob = Carbon::parse($birthdate);

        // Create Carbon instance for current date
        $now = Carbon::now();

        // Calculate age using Carbon's diffInYears(), diffInMonths(), and diffInDays() methods
        $ageYears = $dob->diffInYears($now);
        $ageMonths = $dob->diffInMonths($now) % 12;
        $ageDays = $dob->diffInDays($now) % 30;

        return [
            'years' => $ageYears,
            'months' => $ageMonths,
            'days' => $ageDays
        ];
    }


}
