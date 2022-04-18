<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

/**
 * Class TwoFactorAuthController
 * @package App\Http\Controllers\Auth
 */
class TwoFactorAuthController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth()
    {
        return redirect()->route('admin.home')->with('success', __('You have successfully logged in!'));
    }
}
