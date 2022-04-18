<?php

namespace App\Services;

use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;

/**
 * Class RoleService
 * @package App\Services
 */
class RoleService
{
    /**
     * @var RoleRepository
     */
    protected $repository;

    /**
     * @var PermissionRepository
     */
    protected $permissionRepository;

    /**
     * RoleService constructor.
     * @param RoleRepository $repository
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->repository = $repository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[]
     */
    public function getAllRoles()
    {
        return $this->repository->getAll();
    }

    /**
     * @return mixed
     */
    public function getGroupedPermissions()
    {
        return $this->permissionRepository->getGroupedPermissions();
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function attachPermissionsToRole(array $data, $id)
    {
        $role = $this->repository->show($id);

        if ($role->name === 'Admin') {
            return false;
        }

        return $role->syncPermissions($data['permissions']);
    }
}
