<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SportField;

class SportFieldController extends Controller
{
    public function list()
    {
        $fields = SportField::all();
        return response()->json($fields, 200);
    }
}
