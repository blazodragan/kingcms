<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $results = $this->globalSearch($query);

        return response()->json(['results' => $results]);
    }
    

    private function globalSearch($query)
    {
        $models = [
            \App\Models\News::class,
            \App\Models\Category::class,
            \App\Models\Review::class,
            \App\Models\TrustReview::class,
            \App\Models\User::class,
        ];

        $results = [];

        foreach ($models as $model) {
            $modelInstance = new $model;
            if (isset($modelInstance->searchable) && is_array($modelInstance->searchable)) {
                $searchableFields = $modelInstance->searchable;
                
                $modelResults = $model::where(function ($q) use ($searchableFields, $query) {
                    foreach ($searchableFields as $field) {
                        $q->orWhere($field, 'LIKE', '%' . $query . '%');
                    }
                })->get();

                foreach ($modelResults as $result) {
                    $results[] = [
                        'title' => $result->{$searchableFields[0]},  // assuming first field is 'title' or similar primary descriptor
                    ];
                }
            }
        }

        return $results;
    }
}
