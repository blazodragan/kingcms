<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\Status;

class AuthorController extends Controller
{
    public function show($slug)
    {

        $user = User::where('slug', $slug)->firstOrFail();
        
        // Load the user's published pages
        $user->load(['pages' => function ($query) {
            $query->where('status', Status::PUBLISHED)
                  ->whereDate('published_at', '<=', now())
                  ->where('is_parent', 0)
                  ->whereNotNull('parent_id')
                  ->with('parent');
        }]);

        // Load the user's published reviews with a published_at date of today or earlier
        $user->load(['reviews' => function ($query) {
            $query->where('status', Status::PUBLISHED)
                ->whereDate('published_at', '<=', now());
        }]);

        // Render the page (e.g., using a view)
        return view('author.show', compact('user'));
    }
}
