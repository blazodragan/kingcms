<?php
// app/Traits/IconRetriever.php
namespace App\Traits;

use Illuminate\Support\Facades\File;

trait GlobalSearchTrait
{
    public function globalSearch($query)
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
                        'title' => $result->title,
                        'edit_link' => route('edit.' . strtolower(class_basename($model)), ['id' => $result->id])
                    ];
                }
            }
        }

        return $results;
    }
}