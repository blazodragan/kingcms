<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
            \App\Models\Page::class,
            \App\Models\Category::class,
            \App\Models\Review::class,

        ];

        $results = [];

        foreach ($models as $model) {
            $modelInstance = new $model;
            if (isset($modelInstance->searchable) && is_array($modelInstance->searchable)) {
                $searchableFields = $modelInstance->searchable;
                
                $modelResults = $model::where(function ($q) use ($searchableFields, $query) {
                    foreach ($searchableFields as $field) {
                        $q->orWhere(DB::raw('LOWER(' . $field . ')'), 'LIKE', '%' . strtolower($query) . '%');
                    }
                })->take(10)->get();

                $groupedResults = [];

                foreach ($modelResults as $result) {
                    
                    $modelName = strtolower(class_basename($model));
                    $routeName = $modelName . '.edit'; // assumes your routes are named like 'model.edit'
                    
                    $editLink = ''; // default to an empty string

                    if(Route::has($routeName)) {
                        $editLink = route($routeName, [$modelName => $result->id]);
                    }

                    if (!isset($groupedResults[$model])) {
                        $groupedResults[$model] = [];
                    }

                    $results[$modelName][] = [
                        'title' => $result->{$searchableFields[0]},  // assuming first field is 'title' or similar primary descriptor
                        'edit_link' => $editLink
                    ];
                }
            }
        }
        
        
        return $results;
    }
}
