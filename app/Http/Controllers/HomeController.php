<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\TrustReview;

class HomeController extends Controller
{
    public function index()
    {

        $page = Page::where('is_index', true)
        ->orderBy('published_at', 'desc')
        ->with('faqs')  // Load the faqs polymorphic relationship
        ->first();

        $reviews  = TrustReview::limit(12)->get();
        

        return view('welcome', compact('page','reviews'));
    }


}
