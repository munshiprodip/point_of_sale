<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\MediaLibrary;
use Image;
use Illuminate\Support\Facades\File; 

class MediaLibraryController extends Controller
{
    public function allMedia()
    {
        $media_library = MediaLibrary::where('status', 1)->where('created_by', auth()->user()->id)->get();
        return response()->json([
            'success' => true,
            'status' => 200,
            'media' => $media_library,
        ]);
    }

    public function store(Request $request)
    {
        if($request->hasFile('new_media')){
            $new_media = $request->file('new_media');
            $filename = time() . '.' . $new_media->getClientOriginalExtension();
            $path = public_path('/images/media_library/' . $filename);
            Image::make($new_media)->resize(300, 300)->save($path);

            $media_library = new MediaLibrary;
            $media_library->name = $new_media->getClientOriginalName();
            $media_library->path = 'images/media_library/' . $filename;
            $media_library->created_by = auth()->user()->id;
            $media_library->save();
        }

        $all_media = MediaLibrary::where('status', 1)->where('created_by', auth()->user()->id)->get();
        return response()->json([
            'success' => true,
            'status' => 200,
            'media' => $all_media,
        ]);

    }
}
