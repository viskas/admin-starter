<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Class ImpersonateService
 * @package App\Services
 */
class ImpersonateService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var GoogleTwoStepAuthService
     */
    protected $googleTwoStepAuthService;

    /**
     * ImpersonateService constructor.
     * @param UserRepository $userRepository
     * @param GoogleTwoStepAuthService $googleTwoStepAuthService
     */
    public function __construct(UserRepository $userRepository, GoogleTwoStepAuthService $googleTwoStepAuthService)
    {
//        $this->checkAuth();
        $this->userRepository = $userRepository;
        $this->googleTwoStepAuthService = $googleTwoStepAuthService;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function login ($id)
    {
        $user = $this->userRepository->show($id);
        $currentUser = $this->userRepository->showAuthUser();

        if ($currentUser->id == $user->id) {
            return false;
        }

        $meta = [
            'user_id'  => $currentUser->id,
            'back_url'  => url()->previous(),
            'target_user' => $user->id
        ];

        Session::put('impersonation', json_encode($meta));

        return $user;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function logout()
    {
        if(Session::has('impersonation')) {
            $s = json_decode(Session::get('impersonation'));

            if(json_last_error() === JSON_ERROR_NONE){
                if(isset($s->user_id)){
                    Session::forget('impersonation');
                    Auth::loginUsingId($s->user_id);
                    $this->googleTwoStepAuthService->login();

                    return $s->back_url;
                }
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function checkAuth()
    {
        if(!Auth::check()) {
            abort(403);
        }

        return true;
    }
}
