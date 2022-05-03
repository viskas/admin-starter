<?php

namespace App\Repositories;

use App\Models\Session;

/**
 * Class SessionRepository
 * @package App\Repositories
 */
class SessionRepository
{
    /**
     * @var Session
     */
    protected $model;

    /**
     * SessionRepository constructor.
     * @param Session $model
     */
    public function __construct(Session $model)
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
     * @param $userId
     * @param int $perPage
     * @return mixed
     */
    public function getAuthUserSessions($userId, $perPage = 20)
    {
        return $this->model
            ->where('user_id', $userId)
            ->orderBy('last_activity', 'DESC')
            ->paginate($perPage);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->show($id)->delete();
    }
}
