<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\CreateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;

/**
 * Class RoleController
 * @package App\Http\Controllers\Admin
 */
class RoleController extends Controller
{
    /**
     * @var RoleService
     */
    protected $roleService;

    /**
     * RoleController constructor.
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles();
        $permissions = $this->roleService->getGroupedPermissions();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * @param CreateRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRoleRequest $request)
    {
        $this->roleService->create($request->only('name'));

        return redirect()->back()->with('success', __('Role successfully added.'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (!$this->roleService->attachPermissionsToRole($request->all(), $id)) {
            return redirect()->route('admin.role.index')->with('error', __('You cannot change administrator permissions.'));
        }

        return redirect()->route('admin.role.index')->with('success', __('Role permissions has been updated.'));
    }
}
