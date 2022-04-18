<?php

namespace App\Repositories;

use App\Http\Filters\UserFilter;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function showAuthUser()
    {
        return Auth::user();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserRolesArray($id)
    {
        $user = $this->show($id);

        return $user->roles->pluck('name')->toArray();
    }

    /**
     * @param UserFilter $request
     * @param int $perPage
     * @return mixed
     */
    public function search(UserFilter $request, $perPage = 20)
    {
        return $this->model->sortable()
            ->with('roles')
            ->filter($request)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
    }

    /**
     * @return mixed
     */
    public function getAllUsersCount()
    {
        return $this->model->count();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @return bool
     */
    public function update()
    {
        return $this->model->update();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fill(array $data)
    {
        $this->model->fill($data);

        return $this;
    }

    /**
     * @return bool
     */
    public function save()
    {
        return $this->model->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->show($id)->delete();
    }

    /**
     * @param User $model
     * @return $this
     */
    public function setModel(User $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return User
     */
    public function getModel()
    {
        return $this->model;
    }
}
