<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhilippineController extends Controller
{
    //

    public function getAllLocations() {

        $philippines = json_decode(file_get_contents(public_path() . "/philippine/philippines.json"), true);
        return response()->json(
            [
                'philippines' => $philippines,
            ]
        );

    }
}
