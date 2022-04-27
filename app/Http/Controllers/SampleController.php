<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function getElibs() {
        return view('pages.sample.elibs');
    }

    public function getCropperView() {
        return view('pages.sample.cropper');
    }
    
    public function getCropperViewReal() {
        return view('pages.sample.cropperJs');
    }

    
    public function getMarkAnthony() {
        return view('pages.sample.mark-anthony');
    }

    public function getCropperUpload(Request $request)
    {
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.png';

        file_put_contents($file, $image_base64);

        return response()->json(['success'=>'success']);
    }
}
