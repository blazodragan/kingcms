<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use app\Settings\GeneralSettings;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $settings = app(GeneralSettings::class);

         // Fetching the global search results based on the query
        $query = $request->get('q');
        $results = $query ? $this->globalSearch($query) : [];

        return array_merge(parent::share($request), [
            
            'message' => fn () => $request->session()->get('message'),
            'admin_path' => config('app.admin_path'),
            'toast' => session('toast'),
            'authorization' => [
                'permissions' => fn () => $request->user('web') ? $request->user('web')->getAllPermissions()->pluck('name') : [],
            ],
            'settings' => [
                'available_locales' => $settings->available_locales,
            ],
            'sort' => fn () => $request->get('sort'),
            'filter' => fn () => $request->get('filter'),
            'premit' => fn () => $request->user('web') ? $request->user('web')->getAllPermissions()->pluck('name') : [],
            'csrf_token' => csrf_token(),
            'results' => fn() => $results,  

        ]);
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
