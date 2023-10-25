<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteLinkController extends Controller
{
    public function fetchLinks(Request $request)
{
    // Get search term from request
    $search = $request->get('search', '');

    // Query the database
    $links = DB::table('site_links')
                ->where('url', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%') // If you want to search in descriptions as well.
                ->limit(10) // Limit the number of results. Adjust as needed.
                ->get();

    return response()->json($links);
}
}
