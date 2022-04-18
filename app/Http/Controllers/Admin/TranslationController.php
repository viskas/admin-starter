<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use App\Http\Requests\Admin\Translations\CreateLanguageFileRequest;

/**
 * Class TranslationController
 * @package App\Http\Controllers\Admin
 */
class TranslationController extends Controller
{
    /**
     * @var TranslationService
     */
    private $translationService;

    /**
     * TranslationController constructor.
     * @param TranslationService $translationService
     */
    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $defaultLocale = $this->translationService->getDefaultLocale();
        $availableTranslations = $this->translationService->getTranslationsWithDifferences();

        return view('admin.translations.index', compact('availableTranslations', 'defaultLocale'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $filteredTranslations = $this->translationService->filter($request->only('Translation'));

        $this->translationService->saveTranslations($filteredTranslations);

        return redirect()->back()->with('success', __('Successfully updated.'));
    }

    /**
     * @param CreateLanguageFileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLanguage(CreateLanguageFileRequest $request)
    {
        $this->translationService->addLanguage($request->file('localeFile'));

        return redirect()->back()->with('success', __('New file successfully added!'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rescan()
    {
        $this->translationService->sync(true);

        return redirect()->back()->with('success', __('Rescan successfully completed!'));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return $this->translationService->export();
    }

    /**
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($locale)
    {
        $this->translationService->deleteLanguage($locale);

        return redirect()->back()->with('success', __('Translation file successfully deleted!'));
    }
}
