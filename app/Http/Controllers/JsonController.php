<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function getJsonData() {
        return view('pages.json.index');
    }

    public function postJsonName(Request $request) {
        $file_name = $request['json'];

        if(!is_file($file_name)){
            $contents = '{"name": "damulag"}';
            file_put_contents(public_path().$file_name, $contents);
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Nice One'
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage()
                ]
            );
        }
    }
}

