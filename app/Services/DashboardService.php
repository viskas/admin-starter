<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;

/**
 * Class DashboardService
 * @package App\Services
 */
class DashboardService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var NewsRepository
     */
    protected $newsRepository;

    /**
     * DashboardService constructor.
     * @param UserRepository $userRepository
     * @param NewsRepository $newsRepository
     */
    public function __construct(UserRepository $userRepository, NewsRepository $newsRepository)
    {
        $this->userRepository = $userRepository;
        $this->newsRepository = $newsRepository;
    }

    /**
     * @return mixed
     */
    public function getUsersCount()
    {
        return $this->userRepository->getAllUsersCount();
    }

    /**
     * @return mixed
     */
    public function getAllNewsCount()
    {
        return $this->newsRepository->getAllNewsCount();
    }

    /**
     * @return mixed
     */
    public function getActiveNewsCount()
    {
        return $this->newsRepository->getAllActiveNewsCount();
    }
}
