<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrequentlyAskedQuestion;

class FrequentlyAskedQuestionController extends Controller
{
    public function list()
    {
        $faqs = FrequentlyAskedQuestion::all();
        return response()->json($faqs, 200);
    }
}
