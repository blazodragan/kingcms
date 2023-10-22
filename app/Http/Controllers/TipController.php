<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tip;

class TipController extends Controller
{
    public function index(Request $request)
    {
        $modelType = $request->input('modelType');
        $modelId = $request->input('modelId');

        $tips = Tip::where('tipable_type', $modelType)->where('tipable_id', $modelId)->get();

        return response()->json($tips);
    }
}
