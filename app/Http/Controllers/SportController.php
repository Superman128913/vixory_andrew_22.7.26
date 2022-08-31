<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;

class SportController extends Controller
{

    /**
     * Get a list of sports with relations and data.
     */
    public function listFull()
    {
        $sports = Sport::where("is_active", "=", true)->get();
        return response()->json($sports, 200);
    }

    /**
     * Get a list of sports in key/value format.
     */
    public function list()
    {
        $sports = Sport::where("is_active", "=", true)->get();
        $reformatted = models_to_key_value($sports);
        return response()->json($reformatted, 200);
    }
}
