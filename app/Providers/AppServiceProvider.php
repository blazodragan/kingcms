<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BlockResolver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use app\Settings\GeneralSettings;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blade::directive('block', function ($expression) {
            return "<?php echo app(App\Services\BlockResolver::class)->resolve($expression); ?>";
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('unique_locale_slug', function ($attribute, $value, $parameters, $validator) {
            // First parameter: table name, default to 'categories'
            $tableName = $parameters[0] ?? 'categories';
    
            // Second parameter: default locale, default to settings' default_locale
            $settings = app(GeneralSettings::class);
            $defaultLocale = $parameters[1] ?? $settings->default_locale;
    
            return !\DB::table($tableName)
                ->whereJsonContains('slug->'.$defaultLocale, $value)
                ->exists();
        }, 'The :attribute has already been taken.');

        $this->loadViewsFrom(resource_path('views/email_templates'), 'email_templates');
    }

    
}
