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

    public function patientList(Request $request)
    {
        $patients = Patient::where('id', '>', 0);
        //$patients = Patient::where('created_by', auth()->id());
        if($request->ajax()){
            return DataTables::of($patients)
            ->addColumn('appointment_count', function($row){
                return $row->appointments->count();
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('patients.index');
    }

    public function newAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $patient = Patient::findOrFail($request->patient_id);
        $appointment = $patient->appointments()->where('created_by', auth()->id())->whereDate('created_at', Carbon::today())->first();

        if($appointment){
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'appointment' => $appointment,
                'message'   => 'This patient allready appointed today',
            ]); 
        }
        $appointment = Appointment::create([
            'appointment_no'    => $this->generateUniqueId('appointments', 'appointment_no', 'C'),
            'patient_id'        => $patient->id,
            'appointment_fee'   => auth()->user()->appointment_fee,
            'created_by'        => auth()->id(),
        ]);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'appointment' => $appointment,
            'message'   => 'Appointment created successfully',
        ]); 
    }

    

    public function create()
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
        $religions = [
            0 => 'Muslim',
            1 => 'Hindu',
        ];
        $marital_status = [
            0 => 'Married',
            1 => 'Unmarried',
        ];
        return view('patients.appointments.create', compact('bloodgroups', 'genders', 'religions', 'marital_status'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'    => 'required',
            'appointment_fee'    => 'required',
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
            'appointment_fee'   => request('appointment_fee', auth()->user()->appointment_fee),
            'created_by'        => auth()->id(),
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

        $appointment->opthalmology_option_1 =   request('opthalmology_option_1', $appointment->opthalmology_option_1);
        $appointment->opthalmology_option_2 =   request('opthalmology_option_2', $appointment->opthalmology_option_2);
        $appointment->opthalmology_option_3 =   request('opthalmology_option_3', $appointment->opthalmology_option_3);
        $appointment->opthalmology_option_4 =   request('opthalmology_option_4', $appointment->opthalmology_option_4);
        $appointment->opthalmology_option_5 =   request('opthalmology_option_5', $appointment->opthalmology_option_5);
        $appointment->opthalmology_option_6 =   request('opthalmology_option_6', $appointment->opthalmology_option_6);
        $appointment->opthalmology_option_7 =   request('opthalmology_option_7', $appointment->opthalmology_option_7);
        $appointment->opthalmology_option_8 =   request('opthalmology_option_8', $appointment->opthalmology_option_8);
        $appointment->opthalmology_option_9 =   request('opthalmology_option_9', $appointment->opthalmology_option_9);
        $appointment->opthalmology_option_10    =   request('opthalmology_option_10', $appointment->opthalmology_option_10);
        $appointment->opthalmology_option_11    =   request('opthalmology_option_11', $appointment->opthalmology_option_11);
        $appointment->opthalmology_option_12    =   request('opthalmology_option_12', $appointment->opthalmology_option_12);
        $appointment->opthalmology_option_13    =   request('opthalmology_option_13', $appointment->opthalmology_option_13);
        $appointment->opthalmology_option_14    =   request('opthalmology_option_14', $appointment->opthalmology_option_14);
        $appointment->opthalmology_option_15    =   request('opthalmology_option_15', $appointment->opthalmology_option_15);
        $appointment->opthalmology_option_16    =   request('opthalmology_option_16', $appointment->opthalmology_option_16);
        $appointment->opthalmology_option_17    =   request('opthalmology_option_17', $appointment->opthalmology_option_17);
        $appointment->opthalmology_option_18    =   request('opthalmology_option_18', $appointment->opthalmology_option_18);
        $appointment->opthalmology_option_19    =   request('opthalmology_option_19', $appointment->opthalmology_option_19);
        $appointment->opthalmology_option_20    =   request('opthalmology_option_20', $appointment->opthalmology_option_20);
        $appointment->opthalmology_option_21    =   request('opthalmology_option_21', $appointment->opthalmology_option_21);
        $appointment->opthalmology_option_22    =   request('opthalmology_option_22', $appointment->opthalmology_option_22);
        $appointment->opthalmology_option_23    =   request('opthalmology_option_23', $appointment->opthalmology_option_23);
        $appointment->opthalmology_option_24    =   request('opthalmology_option_24', $appointment->opthalmology_option_24);
        $appointment->opthalmology_option_25    =   request('opthalmology_option_25', $appointment->opthalmology_option_25);

        $appointment->child_history_option_1    =   request('child_history_option_1', $appointment->child_history_option_1);
        $appointment->child_history_option_2    =   request('child_history_option_2', $appointment->child_history_option_2);
        $appointment->child_history_option_3    =   request('child_history_option_3', $appointment->child_history_option_3);
        $appointment->child_history_option_4    =   request('child_history_option_4', $appointment->child_history_option_4);
        $appointment->child_history_option_5    =   request('child_history_option_5', $appointment->child_history_option_5);
        $appointment->child_history_option_6    =   request('child_history_option_6', $appointment->child_history_option_6);
        $appointment->child_history_option_7    =   request('child_history_option_7', $appointment->child_history_option_7);
        $appointment->child_history_option_8    =   request('child_history_option_8', $appointment->child_history_option_8);
        $appointment->child_history_option_9    =   request('child_history_option_9', $appointment->child_history_option_9);
        $appointment->child_history_option_10   =   request('child_history_option_10', $appointment->child_history_option_10);
        $appointment->child_history_option_11   =   request('child_history_option_11', $appointment->child_history_option_11);
        $appointment->child_history_option_12   =   request('child_history_option_12', $appointment->child_history_option_12);
        $appointment->child_history_option_13   =   request('child_history_option_13', $appointment->child_history_option_13);
        $appointment->child_history_option_14   =   request('child_history_option_14', $appointment->child_history_option_14);
        $appointment->child_history_option_15   =   request('child_history_option_15', $appointment->child_history_option_15);
        $appointment->child_history_option_16   =   request('child_history_option_16', $appointment->child_history_option_16);
        $appointment->child_history_option_17   =   request('child_history_option_17', $appointment->child_history_option_17);
        $appointment->child_history_option_18   =   request('child_history_option_18', $appointment->child_history_option_18);
        $appointment->child_history_option_19   =   request('child_history_option_19', $appointment->child_history_option_19);
        $appointment->child_history_option_20   =   request('child_history_option_20', $appointment->child_history_option_20);
        $appointment->child_history_option_21   =   request('child_history_option_21', $appointment->child_history_option_21);
        $appointment->child_history_option_22   =   request('child_history_option_22', $appointment->child_history_option_22);
        $appointment->child_history_option_23   =   request('child_history_option_23', $appointment->child_history_option_23);
        $appointment->child_history_option_24   =   request('child_history_option_24', $appointment->child_history_option_24);
        $appointment->child_history_option_25   =   request('child_history_option_25', $appointment->child_history_option_25);
        $appointment->child_history_option_26   =   request('child_history_option_26', $appointment->child_history_option_26);
        $appointment->child_history_option_27   =   request('child_history_option_27', $appointment->child_history_option_27);
        $appointment->child_history_option_28   =   request('child_history_option_28', $appointment->child_history_option_28);
        $appointment->child_history_option_29   =   request('child_history_option_29', $appointment->child_history_option_29);
        $appointment->child_history_option_30   =   request('child_history_option_30', $appointment->child_history_option_30);
        $appointment->child_history_option_31   =   request('child_history_option_31', $appointment->child_history_option_31);
        $appointment->child_history_option_32   =   request('child_history_option_32', $appointment->child_history_option_32);
        $appointment->child_history_option_33   =   request('child_history_option_33', $appointment->child_history_option_33);
        $appointment->child_history_option_34   =   request('child_history_option_34', $appointment->child_history_option_34);
        $appointment->child_history_option_35   =   request('child_history_option_35', $appointment->child_history_option_35);
        $appointment->child_history_option_36   =   request('child_history_option_36', $appointment->child_history_option_36);
        $appointment->child_history_option_37   =   request('child_history_option_37', $appointment->child_history_option_37);
        $appointment->child_history_option_38   =   request('child_history_option_38', $appointment->child_history_option_38);
        $appointment->child_history_option_39   =   request('child_history_option_39', $appointment->child_history_option_39);
        $appointment->child_history_option_40   =   request('child_history_option_40', $appointment->child_history_option_40);
        $appointment->child_history_option_41   =   request('child_history_option_41', $appointment->child_history_option_41);
        $appointment->child_history_option_42   =   request('child_history_option_42', $appointment->child_history_option_42);
        $appointment->child_history_option_43   =   request('child_history_option_43', $appointment->child_history_option_43);
        $appointment->child_history_option_44   =   request('child_history_option_44', $appointment->child_history_option_44);
        $appointment->child_history_option_45   =   request('child_history_option_45', $appointment->child_history_option_45);
        $appointment->child_history_option_46   =   request('child_history_option_46', $appointment->child_history_option_46);
        $appointment->child_history_option_47   =   request('child_history_option_47', $appointment->child_history_option_47);
        $appointment->child_history_option_48   =   request('child_history_option_48', $appointment->child_history_option_48);
        $appointment->child_history_option_49   =   request('child_history_option_49', $appointment->child_history_option_49);
        $appointment->child_history_option_50   =   request('child_history_option_50', $appointment->child_history_option_50);
        $appointment->child_history_option_51   =   request('child_history_option_51', $appointment->child_history_option_51);
        $appointment->child_history_option_52   =   request('child_history_option_52', $appointment->child_history_option_52);
        $appointment->child_history_option_53   =   request('child_history_option_53', $appointment->child_history_option_53);
        $appointment->child_history_option_54   =   request('child_history_option_54', $appointment->child_history_option_54);
        $appointment->child_history_option_55   =   request('child_history_option_55', $appointment->child_history_option_55);
        $appointment->child_history_option_56   =   request('child_history_option_56', $appointment->child_history_option_56);
        $appointment->child_history_option_57   =   request('child_history_option_57', $appointment->child_history_option_57);
        $appointment->child_history_option_58   =   request('child_history_option_58', $appointment->child_history_option_58);
        $appointment->child_history_option_59   =   request('child_history_option_59', $appointment->child_history_option_59);
        $appointment->child_history_option_60   =   request('child_history_option_60', $appointment->child_history_option_60);
        $appointment->child_history_option_61   =   request('child_history_option_61', $appointment->child_history_option_61);
        $appointment->child_history_option_62   =   request('child_history_option_62', $appointment->child_history_option_62);
        $appointment->child_history_option_63   =   request('child_history_option_63', $appointment->child_history_option_63);
        $appointment->child_history_option_64   =   request('child_history_option_64', $appointment->child_history_option_64);
        $appointment->child_history_option_65   =   request('child_history_option_65', $appointment->child_history_option_65);
        $appointment->child_history_option_66   =   request('child_history_option_66', $appointment->child_history_option_66);
        $appointment->child_history_option_67   =   request('child_history_option_67', $appointment->child_history_option_67);
        $appointment->child_history_option_68   =   request('child_history_option_68', $appointment->child_history_option_68);
        $appointment->child_history_option_69   =   request('child_history_option_69', $appointment->child_history_option_69);
        $appointment->child_history_option_70   =   request('child_history_option_70', $appointment->child_history_option_70);
        $appointment->child_history_option_71   =   request('child_history_option_71', $appointment->child_history_option_71);
        $appointment->child_history_option_72   =   request('child_history_option_72', $appointment->child_history_option_72);
        $appointment->child_history_option_73   =   request('child_history_option_73', $appointment->child_history_option_73);
        $appointment->child_history_option_74   =   request('child_history_option_74', $appointment->child_history_option_74);
        $appointment->child_history_option_75   =   request('child_history_option_75', $appointment->child_history_option_75);
        $appointment->child_history_option_76   =   request('child_history_option_76', $appointment->child_history_option_76);
        $appointment->child_history_option_77   =   request('child_history_option_77', $appointment->child_history_option_77);
        $appointment->child_history_option_78   =   request('child_history_option_78', $appointment->child_history_option_78);
        $appointment->child_history_option_79   =   request('child_history_option_79', $appointment->child_history_option_79);
        $appointment->child_history_option_80   =   request('child_history_option_80', $appointment->child_history_option_80);
        $appointment->child_history_option_81   =   request('child_history_option_81', $appointment->child_history_option_81);
        $appointment->child_history_option_82   =   request('child_history_option_82', $appointment->child_history_option_82);
        $appointment->child_history_option_83   =   request('child_history_option_83', $appointment->child_history_option_83);
        $appointment->child_history_option_84   =   request('child_history_option_84', $appointment->child_history_option_84);
        $appointment->child_history_option_85   =   request('child_history_option_85', $appointment->child_history_option_85);
        $appointment->child_history_option_86   =   request('child_history_option_86', $appointment->child_history_option_86);
        $appointment->child_history_option_87   =   request('child_history_option_87', $appointment->child_history_option_87);
        $appointment->child_history_option_88   =   request('child_history_option_88', $appointment->child_history_option_88);
        $appointment->child_history_option_89   =   request('child_history_option_89', $appointment->child_history_option_89);
        $appointment->child_history_option_90   =   request('child_history_option_90', $appointment->child_history_option_90);
        $appointment->child_history_option_91   =   request('child_history_option_91', $appointment->child_history_option_91);
        $appointment->child_history_option_92   =   request('child_history_option_92', $appointment->child_history_option_92);
        $appointment->child_history_option_93   =   request('child_history_option_93', $appointment->child_history_option_93);
        $appointment->child_history_option_94   =   request('child_history_option_94', $appointment->child_history_option_94);
        $appointment->child_history_option_95   =   request('child_history_option_95', $appointment->child_history_option_95);

        $appointment->obs_history_option_1  =   request('obs_history_option_1', $appointment->obs_history_option_1);
        $appointment->obs_history_option_2  =   request('obs_history_option_2', $appointment->obs_history_option_2);
        $appointment->obs_history_option_3  =   request('obs_history_option_3', $appointment->obs_history_option_3);
        $appointment->obs_history_option_4  =   request('obs_history_option_4', $appointment->obs_history_option_4);
        $appointment->obs_history_option_5  =   request('obs_history_option_5', $appointment->obs_history_option_5);
        $appointment->obs_history_option_6  =   request('obs_history_option_6', $appointment->obs_history_option_6);
        $appointment->obs_history_option_7  =   request('obs_history_option_7', $appointment->obs_history_option_7);
        $appointment->obs_history_option_8  =   request('obs_history_option_8', $appointment->obs_history_option_8);
        $appointment->obs_history_option_9  =   request('obs_history_option_9', $appointment->obs_history_option_9);
        $appointment->obs_history_option_10 =   request('obs_history_option_10', $appointment->obs_history_option_10);
        $appointment->obs_history_option_11 =   request('obs_history_option_11', $appointment->obs_history_option_11);
        $appointment->obs_history_option_12 =   request('obs_history_option_12', $appointment->obs_history_option_12);
        $appointment->obs_history_option_13 =   request('obs_history_option_13', $appointment->obs_history_option_13);
        $appointment->obs_history_option_14 =   request('obs_history_option_14', $appointment->obs_history_option_14);
        $appointment->obs_history_option_15 =   request('obs_history_option_15', $appointment->obs_history_option_15);
        $appointment->obs_history_option_16 =   request('obs_history_option_16', $appointment->obs_history_option_16);
        $appointment->obs_history_option_17 =   request('obs_history_option_17', $appointment->obs_history_option_17);
        $appointment->obs_history_option_18 =   request('obs_history_option_18', $appointment->obs_history_option_18);
        $appointment->obs_history_option_19 =   request('obs_history_option_19', $appointment->obs_history_option_19);
        $appointment->obs_history_option_20 =   request('obs_history_option_20', $appointment->obs_history_option_20);
        $appointment->obs_history_option_21 =   request('obs_history_option_21', $appointment->obs_history_option_21);
        $appointment->obs_history_option_22 =   request('obs_history_option_22', $appointment->obs_history_option_22);
        $appointment->obs_history_option_23 =   request('obs_history_option_23', $appointment->obs_history_option_23);
        $appointment->obs_history_option_24 =   request('obs_history_option_24', $appointment->obs_history_option_24);
        $appointment->obs_history_option_25 =   request('obs_history_option_25', $appointment->obs_history_option_25);

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
        $personal_settings = auth()->user()->settings()->first();
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
            return view('patients.appointments.prescribe', compact('appointment', 'bloodgroups', 'genders', 'religions', 'marital_status', 'ageText', 'examination_values', 'brands', 'doses', 'instructions', 'durations', 'personal_settings'));
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
        $personal_settings = auth()->user()->settings()->first();
        $appointment = Appointment::find($appointment_id);
        $pdf = PDF::loadView('patients.prescriptions.index2', compact('appointment', 'personal_settings'));
        return $pdf->stream($appointment->id.'.pdf');
        //return view('patients.prescriptions.index', compact('appointment', 'personal_settings'));
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
