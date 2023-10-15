<?php

namespace App\Translations;

use App\Settings\GeneralSettings;
use App\Translations\Repositories\LanguageLineRepository;
use App\Translations\Scanners\Contracts\ExternalScannerInterface;
use App\Translations\Scanners\Contracts\ScannerInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use InvalidScannerException;

class TranslationsProcessor
{
    public function __construct(private LanguageLineRepository $languageLineRepository)
    {
    }

    public function scanTranslations()
    {
        $this->languageLineRepository->deleteLanguageLines();

        // local translations

        collect(config('app.translations.scan'))->each(function (array $options, string $scanner) {
            
            $scanner = new $scanner();
            if (! $scanner instanceof ScannerInterface) {
                throw new InvalidScannerException();
            }
            $scanner->addScannedPaths($options['paths'])->scanAndSaveTranslations();
        });

        // external translations

        // collect(config('app.translations.external'))->each(function ($scannerItem) {
            
        //     $group = $scannerItem['group'] ?? null;
        //     collect($scannerItem['scan'])->each(function (array $options, string $scanner) use ($group) {
        //         $scanner = new $scanner();
        //         if (! $scanner instanceof ExternalScannerInterface) {
        //             throw new InvalidScannerException();
        //         }
        //         if ($group) {
        //             $scanner->setGroup($group);
        //         }
        //         $scanner->addScannedPaths($options['paths'])->scanAndSaveTranslations();
        //     });
        // });

        $this->flushTranslationsCache();
    }

    public function publishTranslations()
    {

        collect(config('app.translations.publish'))->each(function ($options, $key) {
            collect(app(GeneralSettings::class)->available_locales)->each(function ($locale) use ($options, $key) {

                if (! File::exists($options['path'])) {
                    File::makeDirectory($options['path']);
                }

                if (! File::exists($options['path'] . '/' . $locale)) {
                    File::makeDirectory($options['path'] . '/' . $locale);
                }

                $translations = LanguageLine::query()
                    ->whereIn('group', $options['groups'])
                    ->get()
                    ->mapWithKeys(function (LanguageLine $line) use ($locale, $options) {
                        return [
                            $line->group . '.' . $line->key => $line->getTranslation($locale),
                        ];
                    })->toJson();

                File::put($options['path'] . '/' . $locale . '/' . $key . '.json', $translations);
            });
        });
    }

    public function flushTranslationsCache()
    {
        Cache::flush();

        // This does not flush the cache for not published translations. For now, we fallback to flushing whole cache and we will deal with this later

        //        collect(config('craftable-pro.translations.publish'))->each(function ($options, $key) {
        //            collect(app(GeneralSettings::class)->available_locales)->each(function ($locale) use ($options, $key) {
        //                LanguageLine::query()
        //                    ->whereIn('group', $options['groups'])
        //                    ->each(fn (LanguageLine $line) => Cache::forget(LanguageLine::getCacheKey($line->group, $locale)));
        //            });
        //        });
    }
}
