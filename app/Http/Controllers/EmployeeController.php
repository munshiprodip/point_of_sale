<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\Employee;

class EmployeeController extends Controller
{
    function __construct()
    {
        //$this->middleware('permission:Medication Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request)
    {
        if($request->ajax()){
            $employees = Employee::where('organization_id', auth()->user()->organization_id);
            return DataTables::of($employees)
            ->addColumn('department', function($row){
                return $row->department->name;
            })
            ->addColumn('schedule', function($row){
                return $row->schedule->name;
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('employees.index');
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'employment_id' => 'required',
            'department_id'   => 'required',
            'designation'     => 'required',
            'schedule_id'     => 'required',
            'mobile'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $employee = Employee::create([
            'name'                => $request->name,
            'employment_id'       => $request->employment_id,
            'organization_id'     => auth()->user()->organization_id,
            'department_id'       => $request->department_id,
            'designation'         => $request->designation,
            'schedule_id'         => $request->schedule_id,
            'mobile'              => $request->mobile,
            'created_by'          => auth()->id(),
        ]);

        if($employee){
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

    //Find the specified resource in storage & return json response
    public function findById($id)
    {
        $employee = Employee::findOrFail($id);
        if($employee){
            return response()->json([
                'success'       => true,
                'data'     => $employee,
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

    //Update the specified resource in storage & return json response
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'employment_id' => 'required',
            'department_id'   => 'required',
            'designation'     => 'required',
            'schedule_id'     => 'required',
            'mobile'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $employee->name = $request->name;
        $employee->employment_id = $request->employment_id;
        $employee->department_id = $request->department_id;
        $employee->designation = $request->designation;
        $employee->schedule_id = $request->schedule_id;
        $employee->mobile = $request->mobile;
        $employee->save();
      
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Updated successfully',
        ]);
        
    }

    //Change the current status of specified resource from storage & return json response.
    public function changeStatus($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->status = !$employee->status;
        $employee->save();
        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => 'Status changed successfully'
        ]);
    }

    //Remove the specified resource from storage & return json response.
    public function destroy($id)
    {
        Employee::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }
}