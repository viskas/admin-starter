<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileService
 * @package App\Services
 */
class ProfileService
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * @var GoogleTwoStepAuthService
     */
    protected $googleTwoStepAuthService;

    /**
     * ProfileService constructor.
     * @param UserRepository $repository
     * @param UploadService $uploadService
     * @param GoogleTwoStepAuthService $googleTwoStepAuthService
     */
    public function __construct(UserRepository $repository, UploadService $uploadService,
                                GoogleTwoStepAuthService $googleTwoStepAuthService)
    {
        $this->repository = $repository;
        $this->uploadService = $uploadService;
        $this->googleTwoStepAuthService = $googleTwoStepAuthService;
    }

    /**
     * @return mixed
     */
    public function getAuthUser()
    {
        return $this->repository->showAuthUser();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $user = $this->getAuthUser();
        $this->repository->setModel($user)->fill($data);

        if (isset($data['current_password']) && !is_null($data['current_password'])) {
            if (Hash::check($data['current_password'], $user->password)) {
                $this->repository->fill(['password' => $data['new_password']]);
            } else {
                return false;
            }
        }

        return $this->repository->save();
    }

    /**
     * @param $image
     * @return bool
     */
    public function uploadAvatar($image)
    {
        $user = $this->getAuthUser();
        $avatar = $this->uploadService->updateFile('public/avatars/'.$user->id.'/', $image, $user->avatar);

        return $this->repository->setModel($user)
            ->fill(['avatar' => $avatar])
            ->save();
    }

    /**
     * @return bool
     */
    public function deleteAvatar()
    {
        $user = $this->getAuthUser();

        if (!$user->avatar) {
            return false;
        }

        $this->uploadService->deleteFile('public/avatars/'.$user->id.'/', $user->avatar);

        return $this->repository->setModel($user)
            ->fill(['avatar' => null])
            ->save();
    }

    /**
     * @return mixed|null
     */
    public function changeTwoFactor()
    {
        $user = $this->getAuthUser();
        $this->googleTwoStepAuthService->login();

        if (!$user->google2fa_secret) {
            $secret = $this->googleTwoStepAuthService->createSecretKey();
            $this->repository->setModel($user)
                ->fill(['google2fa_secret' => $secret])
                ->save();

            return $secret;
        }

        $this->repository->setModel($user)
                ->fill(['google2fa_secret' => null])
                ->save();

        return null;
    }

    /**
     * @return bool
     */
    public function updateTwoFactorSecret()
    {
        return $this->update([
            'google2fa_secret' => $this->googleTwoStepAuthService->createSecretKey()
        ]);
    }
}
