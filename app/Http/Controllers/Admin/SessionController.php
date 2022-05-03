<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SessionService;
use Jenssegers\Agent\Facades\Agent;

/**
 * Class SessionController
 * @package App\Http\Controllers\Admin
 */
class SessionController extends Controller
{
    /**
     * @var SessionService
     */
    protected $sessionService;

    /**
     * SessionController constructor.
     * @param SessionService $sessionService
     */
    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $sessions = $this->sessionService->getCurrentUserSessions();

        return view('admin.sessions.index', compact('sessions'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->sessionService->delete($id);

        return redirect()->back()->with('success', __('Session successfully deleted.'));
    }
}
