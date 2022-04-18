<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use App\Http\Requests\Admin\Profile\UploadAvatarRequest;
use App\Services\GoogleTwoStepAuthService;
use App\Services\ProfileService;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Admin
 */
class ProfileController extends Controller
{
    /**
     * @var ProfileService
     */
    protected $profileService;

    /**
     * @var GoogleTwoStepAuthService
     */
    protected $googleTwoStepAuthService;

    /**
     * ProfileController constructor.
     * @param ProfileService $profileService
     * @param GoogleTwoStepAuthService $googleTwoStepAuthService
     */
    public function __construct(ProfileService $profileService, GoogleTwoStepAuthService $googleTwoStepAuthService)
    {
        $this->profileService = $profileService;
        $this->googleTwoStepAuthService = $googleTwoStepAuthService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = $this->profileService->getAuthUser();

        $qr = $this->googleTwoStepAuthService->generateQrCode($user->email, $user->google2fa_secret);

        return view('admin.profile', compact('user', 'qr'));
    }

    /**
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        if (!$this->profileService->update($request->all())) {
            return redirect()->back()->withInput()->with('error', __('Invalid current password.'));
        }

        return redirect()->route('admin.profile.index')->with('success', __('Profile successfully updated.'));
    }

    /**
     * @param UploadAvatarRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(UploadAvatarRequest $request)
    {
        if (!$request->hasFile('avatar')) {
            return redirect()->back()->with('warning', __('You have not selected a photo.'));
        }

        $this->profileService->uploadAvatar($request->file('avatar'));

        return redirect()->back()->with('success', __('The photo has been successfully updated.'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAvatar()
    {
        if (!$this->profileService->deleteAvatar()) {
            return redirect()->back()->with('error', __('Failed to delete avatar.'));
        }

        return redirect()->back()->with('success', __('The photo has been successfully deleted.'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateTwoStep()
    {
        if (!$this->profileService->changeTwoFactor()) {
            return redirect()->back()->with('success', __('Two-factor authentication is disabled.'));
        }

        return redirect()->back()->with('info', __('Scan the QR code below.'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function regenerateTwoStepSecret()
    {
        if (!$this->profileService->updateTwoFactorSecret()) {
            return redirect()->back()->with('error', __('Error. Failed to change code.'));
        }

        return redirect()->back()->with('success', __('The code has been successfully changed. Scan a new QR code.'));
    }
}
