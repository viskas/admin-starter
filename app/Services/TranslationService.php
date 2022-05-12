<?php

namespace App\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use ZipArchive;

/**
 * Class TranslationService
 * @package App\Services
 */
class TranslationService
{
    /**
     * @var Filesystem
     */
    protected $disk;

    /**
     * Path to language files
     *
     * @var string
     */
    protected $languageFilesPath;

    /**
     * Available translations.
     *
     * @var array
     */
    protected $translations = [];

    /**
     * TranslationService constructor.
     * @param Filesystem $disk
     */
    public function __construct(Filesystem $disk)
    {
        $this->disk = $disk;
        $this->languageFilesPath = resource_path('lang');
    }

    /**
     * Get all the available lines.
     *
     * @return array
     */
    public function getTranslations()
    {
        collect($this->disk->allFiles($this->languageFilesPath))
            ->filter(function ($file) {
                return $this->disk->extension($file) == 'json';
            })
            ->each(function ($file) {
                $this->translations[str_replace('.json', '', $file->getFilename())]
                    = json_decode($file->getContents());
            });

        return $this->translations;
    }

    /**
     * @return array
     */
    public function getTranslationsWithDifferences()
    {
        $allTranslations = [];
        $translations = $this->getTranslations();
        $defaultLocale = $this->getDefaultLocale();

        foreach ($translations as $locale => $translationCollection) {
            if ($locale == $defaultLocale) {
                $allTranslations[$locale] = (array) $translationCollection;
                continue;
            }

            $defaultTranslationsArray = (array)$translations[$defaultLocale];
            $translationsArray = (array) $translations[$locale];
            $differencesArr = array_diff_key($defaultTranslationsArray, $translationsArray);

            if (empty($differencesArr)) {
                $allTranslations[$locale] = $translationsArray;
                continue;
            }

            $allTranslations[$locale] = $translationsArray;

            foreach ($differencesArr as $key => $value) {
//                $allTranslations[$locale][$key] = '';
                $allTranslations[$locale] = [$key => ''] + $allTranslations[$locale];
            }
        }

        return $allTranslations;
    }

    /**
     * Save the given translations.
     *
     * @param $translations
     */
    public function saveTranslations($translations)
    {
        $this->backup();

        foreach ($translations as $lang => $lines) {
            $filename = $this->languageFilesPath.DIRECTORY_SEPARATOR."$lang.json";

            ksort($lines);

            file_put_contents($filename, json_encode($lines, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        }
    }

    /**
     * @param array $translations
     * @return array
     */
    public function filter(array $translations)
    {
        $filteredTranslations = [];

        foreach ($translations['Translation'] as $locale => $translationArray) {
            foreach ($translationArray as $key => $value) {
                if ($value) {
                    $filteredTranslations[$locale][$key] = $value;
                }
            }
        }

        return $filteredTranslations;
    }

    /**
     * Synchronize the language keys from files.
     *
     * @param bool $initial
     * @return array
     */
    public function sync(bool $initial = false)
    {
        $output = [];
        $translations = $this->getTranslations();
        $keysFromFiles = array_collapse($this->getTranslationsFromFiles());

        foreach (array_unique($keysFromFiles) as $fileName => $key) {
            foreach ($translations as $lang => $keys) {
                if ($lang == $this->getDefaultLocale()) {
                    $output[] = $key;
                }
            }
        }

        if ($initial) {
            $emptyTranslations = [];

            foreach(array_values(array_unique($output)) as $value) {
                $emptyTranslations[$this->getDefaultLocale()][$value] = $value;
            }

            $this->saveTranslations($emptyTranslations);
        }

        return array_values(array_unique($output));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        $zipFile = storage_path('app/public/')."Translations.zip";
        $zip = new ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $path = $this->languageFilesPath;
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'json') {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        return response()->download($zipFile);
    }

    /**
     * Add a new JSON language file.
     *
     * @param $languageFile
     */
    public function addLanguage($languageFile)
    {
        $this->backup();

        file_put_contents($this->languageFilesPath.DIRECTORY_SEPARATOR.$languageFile->getClientOriginalName(),
            json_encode(json_decode($languageFile->get()), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    /**
     * Delete JSON language file.
     *
     * @param $language
     * @return bool
     */
    public function deleteLanguage($language)
    {
        $this->backup();

        return File::delete($this->languageFilesPath.DIRECTORY_SEPARATOR."$language.json");
    }

    /**
     * @return mixed
     */
    public function getDefaultLocale()
    {
        return Config::get('app')['fallback_locale'];
    }

    /**
     * @return int[]|string[]
     */
    public function getAllSupportedLocales()
    {
        $locales = Config::get('laravellocalization')['supportedLocales'];

        return array_keys($locales);
    }

    /**
     * Get found translation lines found per file.
     *
     * @return array
     */
    private function getTranslationsFromFiles()
    {
        /*
         * This pattern is derived from Barryvdh\TranslationManager by Barry vd. Heuvel <barryvdh@gmail.com>
         *
         * https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Manager.php
         */
        $functions = ['__'];

        $pattern =
            // See https://regex101.com/r/jS5fX0/5
            '[^\w]'. // Must not start with any alphanum or _
            '(?<!->)'. // Must not start with ->
            '('.implode('|', $functions).')'.// Must start with one of the functions
            "\(".// Match opening parentheses
            "[\'\"]".// Match " or '
            '('.// Start a new group to match:
            '.+'.// Must start with group
            ')'.// Close group
            "[\'\"]".// Closing quote
            "[\),]"  // Close parentheses or new parameter
        ;

        $allMatches = [];

        foreach ($this->disk->allFiles(app_path()) as $file) {
            if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                $allMatches[$file->getRelativePathname()] = $matches[2];
            }
        }

        foreach ($this->disk->allFiles(resource_path()) as $file) {
            if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                $allMatches[$file->getRelativePathname()] = $matches[2];
            }
        }

        return $allMatches;
    }

    /**
     * @return bool
     */
    private function backup()
    {
        $folderName = now()->format('Y-m-d H-i-s');

        if (!$this->disk->exists(storage_path('app/public/translationBackups'))) {
            $this->disk->makeDirectory(storage_path('app/public/translationBackups'));
        }

        $this->disk->makeDirectory(storage_path('app/public/translationBackups'.DIRECTORY_SEPARATOR.$folderName));

        return $this->disk->copyDirectory($this->languageFilesPath, storage_path('app/public/translationBackups'.DIRECTORY_SEPARATOR.$folderName));
    }
}
