<?php

namespace App\Services;

use App\Http\Filters\UserFilter;
use App\Mail\Admin\UserCreateMail;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var RoleRepository
     */
    protected $roleRepository;

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * @var GoogleTwoStepAuthService
     */
    protected $googleTwoStepAuthService;

    /**
     * UserService constructor.
     * @param UserRepository $repository
     * @param RoleRepository $roleRepository
     * @param UploadService $uploadService
     * @param GoogleTwoStepAuthService $googleTwoStepAuthService
     */
    public function __construct(UserRepository $repository, RoleRepository $roleRepository,
                                UploadService $uploadService, GoogleTwoStepAuthService $googleTwoStepAuthService)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->uploadService = $uploadService;
        $this->googleTwoStepAuthService = $googleTwoStepAuthService;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        return $this->repository->show($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserRolesArray($id)
    {
        return $this->repository->getUserRolesArray($id);
    }

    /**
     * @return mixed
     */
    public function getPluckAllRoles()
    {
        return $this->roleRepository->pluck();
    }

    /**
     * @param UserFilter $request
     * @return mixed
     */
    public function search(UserFilter $request)
    {
        $perPage = $request->getRequest()->per_page ?: 20;

        return $this->repository->search($request, $perPage);
    }

    /**
     * @param $data
     * @return bool
     */
    public function create($data)
    {
        $password = Str::random(10);

        if (isset($data['password']) && !empty($data['password'])) {
            $password = $data['password'];
        }

        $data['password'] = $password;
        $data = Arr::collapse([$data, [
            'email_verified_at' => now()
        ]]);

        $user = $this->repository->create($data);
        $this->syncRoles($user, $data['roles']);

        if (isset($data['image'])) {
            $avatar = $this->uploadService->saveFile('public/avatars/'.$user->id.'/', $data['image']);
            $this->repository->setModel($user)
                ->fill(['avatar' => $avatar])
                ->update();
        }

        Mail::to($data['email'])->send(new UserCreateMail($data['email'], $password));

        return true;
    }

    /**
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $user = $this->repository->show($id);

        if (!isset($data['password']) || empty($data['password'])) {
            $data = Arr::except($data, ['password']);
        }

        $this->repository->setModel($user)
            ->fill($data)
            ->update();
        $this->syncRoles($user, $data['roles']);

        if (isset($data['image'])) {
            $avatar = $this->uploadService->updateFile('public/avatars/'.$user->id.'/', $data['image'], $user->avatar);
            $this->repository->setModel($user)
                ->fill(['avatar' => $avatar])
                ->update();
        }
    }

    /**
     * @param $id
     * @return false|mixed
     */
    public function delete($id)
    {
        if ($id == $this->repository->showAuthUser()->id || $id == 1) {
            return false;
        }

        return $this->repository->delete($id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function resetTwoFactorAuth($id)
    {
        $user = $this->getUserById($id);

        return $this->repository
            ->setModel($user)
            ->fill(['google2fa_secret' => null])
            ->save();
    }

    /**
     * @param $user
     * @param $roles
     * @return mixed
     */
    protected function syncRoles($user, $roles)
    {
        $roles = $this->roleRepository->find($roles);

        return $user->syncRoles($roles);
    }
}
