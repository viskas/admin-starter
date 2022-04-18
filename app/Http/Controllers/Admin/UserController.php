<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\UserFilter;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Services\UserService;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param UserFilter $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(UserFilter $request)
    {
        $users = $this->userService->search($request);

        return view('admin.users.index', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = $this->userService->getPluckAllRoles();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request)
    {
        $this->userService->create($request->all());

        return redirect()->route('admin.users.index')->with('success', __('The user has been successfully created.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $user = $this->userService->getUserById($id);
        $roles = $this->userService->getPluckAllRoles();
        $userRoles = $this->userService->getUserRolesArray($id);

        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->update($id, $request->all());

        return redirect()->route('admin.users.index')->with('success', __('The user has been successfully edited.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetTwoFactorAuth($id)
    {
        $this->userService->resetTwoFactorAuth($id);

        return redirect()->route('admin.users.index')->with('success', __('Two-factor authentication is disabled for the selected user.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (!$this->userService->delete($id)) {
            return redirect()->back()->with('error', __('You cannot delete yourself or a super administrator!'));
        }

        return redirect()->route('admin.users.index')->with('success', __('The user has been deleted.'));
    }
}
