<?php

namespace App\Services;

use App\Repositories\SessionRepository;
use Illuminate\Support\Facades\Auth;

/**
 * Class SessionService
 * @package App\Services
 */
class SessionService
{
    /**
     * @var SessionRepository
     */
    protected $repository;

    /**
     * SessionService constructor.
     * @param SessionRepository $repository
     */
    public function __construct(SessionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getCurrentUserSessions()
    {
        return $this->repository->getAuthUserSessions(Auth::id());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
