<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BlockResolver;
use Illuminate\Support\Facades\Blade;

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
        $this->loadViewsFrom(resource_path('views/email_templates'), 'email_templates');
    }

    
}
