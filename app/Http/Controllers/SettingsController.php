<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\UpdateSettings;
use App\Models\User;
use app\Settings\GeneralSettings;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Traits\HasRoles;


class SettingsController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    //
    public function index()
    {
        $this->authorize('sanctum.settings.edit');

        $settings = app(GeneralSettings::class);

        $availableRoutes = collect(Route::getRoutes())->filter(function ($route) {
            return isset($route->action['prefix'])
                && in_array('GET', $route->methods)
                && Str::between($route->uri, '{', '}') === $route->uri
                && ! in_array($route->uri, [
                    'admin',
                    'admin/login',
                    'admin/forgot-password',
                    'admin/verify-email',
                    'admin/confirm-password',
                    'admin/translations/export',
                ]);
        })->map->uri->values()->toArray();

    return Inertia::render('Settings/Index', [
            'generalSettings' => [
                'available_locales' => $settings->available_locales,
                'default_locale' => $settings->default_locale,
                'default_route' => $settings->default_route,
                'default_siteTitle' => $settings->default_siteTitle,
                'default_siteDescription' => $settings->default_siteDescription,
                'default_googleAnalytics' => $settings->default_googleAnalytics,
                'default_customCss' => $settings->default_customCss,
            ], 'availableRoutes' => $availableRoutes,
        ]);
    }

    public function update(GeneralSettings $settings, UpdateSettings $request)
    {
        
        $sanitized = $request->validated();
        
        $settings->available_locales = $sanitized['available_locales'];
        $settings->default_locale = $sanitized['default_locale'];
        $settings->default_route = $sanitized['default_route'];

        // Need to check if there is anything to updated add
        if ($request->has('default_googleAnalytics')) {
            $settings->default_googleAnalytics = $sanitized['default_googleAnalytics'] ?? '';
        }
        if ($request->has('default_customCss')) {
            $settings->default_customCss = $sanitized['default_customCss'] ?? '';
        }
        // Doing it like this because we can't use tranltable in spati settings component 
        if ($request->has('default_siteTitle')) {

            $data = $request->input('default_siteTitle') ?? '';

  

            foreach ($data as $locale => $translation) {
                $settings->setSiteTitleTranslation($locale, $translation);
            }
        }

        if ($request->has('default_siteDescription')) {

            $data = $request->input('default_siteDescription') ?? '';

            foreach ($data as $locale => $translation) {
                $settings->setSiteDescriptionTranslation($locale, $translation);
            }
        }


        
        $settings->save();



        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Settings successfully updated'),
            'durration' => 2000,
        ]);
    }
}
