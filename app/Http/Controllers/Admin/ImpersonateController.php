<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImpersonateService;
use Illuminate\Support\Facades\Session;

/**
 * Class ImpersonateController
 * @package App\Http\Controllers\Admin
 */
class ImpersonateController extends Controller
{
    /**
     * @var ImpersonateService
     */
    protected $impersonateService;

    /**
     * ImpersonateController constructor.
     * @param ImpersonateService $impersonateService
     */
    public function __construct(ImpersonateService $impersonateService)
    {
        $this->impersonateService = $impersonateService;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login($id)
    {
        $user = $this->impersonateService->login($id);

        if (!$user) {
            return redirect()->back()->with('error', __('You are already authorized under this user.'));
        }

        return redirect()->route('admin.home')->with('info', __('You are logged in as a user :user', ['user' => $user->email]));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $url = $this->impersonateService->logout();

        if (!$url) {
            return redirect()->route('admin.home');
        }

        return redirect()->to($url)->with('info', __('You have successfully signed out of your secondary account.'));
    }
}
