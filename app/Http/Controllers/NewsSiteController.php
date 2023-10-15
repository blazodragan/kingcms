<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsSiteController extends Controller
{
    public function index()
    {
        return view('allnews');
    }
}
