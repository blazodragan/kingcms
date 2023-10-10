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

        ]);
    }
}
