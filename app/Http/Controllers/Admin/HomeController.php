<?php

namespace App\Http\Controllers\Admin;

use App\Services\DashboardService;
use App\Http\Controllers\Controller;

/**
 * Class HomeController
 * @package App\Http\Controllers\Admin
 */
class HomeController extends Controller
{
    /**
     * @var DashboardService
     */
    protected $dashboardService;

    /**
     * HomeController constructor.
     * @param DashboardService $dashboardService
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $widget = [
            'users' => $this->dashboardService->getUsersCount(),
            'articles' => $this->dashboardService->getAllNewsCount(),
            'activeArticles' => $this->dashboardService->getActiveNewsCount()
        ];

        return view('admin.home', compact('widget'));
    }
}
