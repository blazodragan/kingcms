<?php

namespace app\Settings;

use phpDocumentor\Reflection\Types\Null_;
use Spatie\LaravelSettings\Settings;
use Spatie\Translatable\HasTranslations;



class GeneralSettings extends Settings
{
    use HasTranslations;

    public array $available_locales;

    public string $default_locale;

    public string $default_route;

    public array $default_siteTitle;

    public array $default_siteDescription;

    public string $default_googleAnalytics;

    public string $default_customCss;

    public static function group(): string
    {
        return 'general';
    }

    // we need to do it like that because translatable trail is not working here from spati do it manual

    public function getSiteTitleTranslation(string $locale): string
    {
        return $this->default_siteTitle[$locale] ?? $this->default_siteTitle[config('app.locale', 'en')] ?? '';

    }

    public function setSiteTitleTranslation(string $locale, ?string $value)
    {
        $this->default_siteTitle[$locale] = $value;

    }

    public function getSiteDescriptionTranslation(string $locale): string
    {
        return $this->default_siteDescription[$locale] ?? $this->default_siteDescription[config('app.locale', 'en')] ?? '';

    }

    public function setSiteDescriptionTranslation(string $locale, ?string $value)
    {
        $this->default_siteDescription[$locale] = $value;

    }
}
