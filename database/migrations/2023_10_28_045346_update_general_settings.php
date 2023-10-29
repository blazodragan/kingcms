<?php


use Spatie\LaravelSettings\Migrations\SettingsMigration;
use app\Settings\GeneralSettings;

class UpdateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {

        $locales = ['en', 'de'];

        $siteTitles = [];
        $siteDescriptions = [];

        foreach ($locales as $locale) {
            $siteTitles[$locale] = 'default';
            $siteDescriptions[$locale] = 'default';
        }


        $this->migrator->add('general.default_siteTitle', $siteTitles);
        $this->migrator->add('general.default_siteDescription', $siteDescriptions);
        $this->migrator->add('general.default_googleAnalytics', '');
        $this->migrator->add('general.default_customCss', '');
    }
}
