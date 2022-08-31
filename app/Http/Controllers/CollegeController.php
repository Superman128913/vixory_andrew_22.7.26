<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;

class CollegeController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->q;
        $colleges = College::search($query)->get();

        return response()->json($colleges, 200);
    }
}
