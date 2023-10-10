<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAQ;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $modelType = $request->input('modelType');
        $modelId = $request->input('modelId');

        $faqs = FAQ::where('faqable_type', $modelType)->where('faqable_id', $modelId)->get();

        return response()->json($faqs);
    }
}
