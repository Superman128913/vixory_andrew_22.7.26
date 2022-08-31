<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function list()
    {
        $plans = Plan::where("is_active", true)->get();
        return response()->json($plans, 200);
    }
}
