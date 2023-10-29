<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Settings\GeneralSettings;


class GeneralSettingsSeeder extends Seeder
{
    public function up(): void
    {
        $settings = new GeneralSettings();
        $settings->translatable = ['siteName', 'siteDescription'];
        $settings->available_locales = [config('app.locale', 'en')];
        $settings->default_locale = config('app.locale', 'en');
        $settings->default_route = 'admin/craftable-pro-users';
        $settings->setTranslations('default_siteTitle', [
            'en' => 'Default Site Name in English',
            'fr' => 'Default Site Name in French'
        ]);
        
        $settings->setTranslations('default_siteDescription', [
            'en' => 'Default Description in English',
            'fr' => 'Default Description in French'
        ]);
        
        // If you have non-translatable settings
        // $settings->someOtherSetting = 'DefaultValue';
        
        $settings->save();
    }
}
