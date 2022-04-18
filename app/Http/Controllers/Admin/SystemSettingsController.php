<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SystemSettingsService;
use Illuminate\Http\Request;

/**
 * Class SystemSettingsController
 * @package App\Http\Controllers\Admin
 */
class SystemSettingsController extends Controller
{
    /**
     * @var SystemSettingsService
     */
    protected $systemSettingsService;

    /**
     * SystemSettingsController constructor.
     * @param SystemSettingsService $systemSettingsService
     */
    public function __construct(SystemSettingsService $systemSettingsService)
    {
        $this->systemSettingsService = $systemSettingsService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $mailSettings = $this->systemSettingsService->getMailerSettings();
        $systemSettings = $this->systemSettingsService->getSystemSettings();

        return view('admin.systemSettings.index', compact('mailSettings', 'systemSettings'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->systemSettingsService
            ->setKeys($request->except(['_token', '_method']))
            ->save();

        return redirect()->back()->with('success', __('Settings successfully updated.'));
    }
}
