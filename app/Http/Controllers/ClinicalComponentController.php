<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\ClinicalComponent;

class ClinicalComponentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Clinical Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request, $component_type)
    {
        $clinical_components = ClinicalComponent::where('component_type', $component_type);
        if($request->ajax()){
            return DataTables::of($clinical_components)->addIndexColumn()->make(true);
        }
        return view('settings.clinical.clinical_components.index', compact('component_type'));
    }

    // 
    public function selectOptionsSearch(Request $request, $component_type)
    {
        $data = [];
        if($request->has('q')){
            $term = $request->input('q');
            $data = ClinicalComponent::where('name_en', 'LIKE', '%'.$term.'%')
                ->where('component_type' ,$component_type )
                ->limit(30)
                ->get(['id', 'name_en']);
        }
        return response()->json($data);
        
        //return ['results' => $clinical_components];
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en'          => 'required',
            'name_bn'          => 'required',
            'component_type'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $clinical_component = ClinicalComponent::create([
            'name_en' => $request->name_en,
            'name_bn' => $request->name_bn,
            'component_type' => $request->component_type,
            'created_by' => auth()->id(),
        ]);

        if($clinical_component){
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
        $clinical_component = ClinicalComponent::findOrFail($id);
        if($clinical_component){
            return response()->json([
                'success'       => true,
                'data'     => $clinical_component,
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
        $clinical_component = ClinicalComponent::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name_en'          => 'required',
            'name_bn'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $clinical_component->name_en = $request->name_en;
        $clinical_component->name_bn = $request->name_bn;
        $clinical_component->save();
      
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
        $clinical_component = ClinicalComponent::findOrFail($id);
        $clinical_component->status = !$clinical_component->status;
        $clinical_component->save();
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
        ClinicalComponent::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }






    public function getFavouriteComponents(Request $request, $component_type)
    {
        $clinical_components = auth()->user()->favourites($component_type)->get();
        if($request->ajax()){
            return DataTables::of($clinical_components)->addIndexColumn()->make(true);
        }
    }


    public function addComponentToFavourite(Request $request)
    {
        if($request->has('clinical_component_id')){
            if(auth()->user()->clinicalComponents->contains($request->clinical_component_id)){
                return response()->json([
                    'success'   => true,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => "Allready added to favourite!!",
                ]);
            }else{
                auth()->user()->clinicalComponents()->attach($request->clinical_component_id);
                return response()->json([
                    'success'   => true,
                    'type'      => 'success',
                    'title'     => 'Success!',
                    'message' => "Added to favourite!!",
                ]);
            }
        }
    }


    public function removeComponentFromFavourite(Request $request)
    {
        if($request->has('clinical_component_id')){
            if(auth()->user()->clinicalComponents->contains($request->clinical_component_id)){
                auth()->user()->clinicalComponents()->detach($request->clinical_component_id);
                return response()->json([
                    'success'   => true,
                    'type'      => 'success',
                    'title'     => 'Success!',
                    'message' => "Removed from favorites!!",
                ]);
            }else{
                return response()->json([
                    'success'   => true,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => "Something went wrong",
                ]);
            }
        }
    }

    
}