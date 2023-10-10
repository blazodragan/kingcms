<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\StoreTagRequest;
use Illuminate\Routing\Controller;
use Spatie\Tags\Tag;

class TagsController extends Controller
{
    /**
     * Create new tag.
     *
     */
    public function store(StoreTagRequest $request)
    {
        $validated = $request->validated();

        $tag = Tag::findOrCreate($validated['name'], $validated['type']);

        return response()->json($tag);
    }
}
