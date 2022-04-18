<?php

namespace App\Http\Middleware;

use App\Services\GoogleTwoStepAuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Impersonate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('impersonation')) {
            $session = Session::get('impersonation');
            $s = json_decode($session);
            if(json_last_error() === JSON_ERROR_NONE) {
                if(isset($s->target_user)) {
                    if(Auth::id() != $s->target_user) {
                        Auth::loginUsingId($s->target_user);
                        (new GoogleTwoStepAuthService())->login();
                        Session::put('impersonation', $session);
                    }
                }
            }
        }

        return $next($request);
    }
}
