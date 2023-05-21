<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use App\Models\ComponentTemplate;


class ComponentTemplateController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Clinical Settings');
    }
    // Display a listing of the resource & return response for ajax request.
    public function index(Request $request, $template_type)
    {
        $components_templates = ComponentTemplate::where('template_type', $template_type);
        if($request->ajax()){
            return DataTables::of($components_templates)->addIndexColumn()->make(true);
        }
        return view('settings.clinical.components_templates.index', compact('template_type'));
    }

    // 
    public function selectOptionsSearch(Request $request, $template_type)
    {
        $data = [];
        if($request->has('q')){
            $term = $request->input('q');
            $data = ComponentTemplate::where('name_en', 'LIKE', '%'.$term.'%')
                ->where('template_type' ,$template_type )
                ->limit(30)
                ->get(['id', 'name_en']);
        }
        return response()->json($data);
        
        //return ['results' => $components_templates];
    }

    // Store a newly created resource in storage & return json response
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'template_en'          => 'required',
            'template_type'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $components_template = ComponentTemplate::create([
            'name' => $request->name,
            'template_en' => $request->template_en,
            'template_bn' => $request->template_bn,
            'template_type' => $request->template_type,
            'created_by' => auth()->id(),
        ]);

        if($components_template){
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
        $components_template = ComponentTemplate::findOrFail($id);
        if($components_template){
            return response()->json([
                'success'       => true,
                'data'     => $components_template,
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
        $components_template = ComponentTemplate::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'template_en'          => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'type'      => 'info',
                'title'     => 'Info!',
                'message'   => $validator->messages()->all()[0],
            ]);
        }

        $components_template->name = $request->name;
        $components_template->template_en = $request->template_en;
        $components_template->template_bn = $request->template_bn;
        $components_template->save();
      
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
        $components_template = ComponentTemplate::findOrFail($id);
        $components_template->status = !$components_template->status;
        $components_template->save();
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
        ComponentTemplate::destroy($id);

        return response()->json([
            'success'   => true,
            'type'      => 'success',
            'title'     => 'Success!',
            'message' => "Removed successfully!!",
        ]);
    }






    public function getFavouriteComponents(Request $request, $template_type)
    {
        $components_templates = auth()->user()->favourites($template_type)->get();
        if($request->ajax()){
            return DataTables::of($components_templates)->addIndexColumn()->make(true);
        }
    }


    public function addComponentToFavourite(Request $request)
    {
        if($request->has('components_template_id')){
            if(auth()->user()->clinicalComponents->contains($request->components_template_id)){
                return response()->json([
                    'success'   => true,
                    'type'      => 'info',
                    'title'     => 'Info!',
                    'message' => "Allready added to favourite!!",
                ]);
            }else{
                auth()->user()->clinicalComponents()->attach($request->components_template_id);
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
        if($request->has('components_template_id')){
            if(auth()->user()->clinicalComponents->contains($request->components_template_id)){
                auth()->user()->clinicalComponents()->detach($request->components_template_id);
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
