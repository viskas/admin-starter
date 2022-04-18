<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRepository
 * @package App\Repositories
 */
class PermissionRepository
{
    /**
     * @var Permission
     */
    protected $model;

    /**
     * PermissionRepository constructor.
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getGroupedPermissions()
    {
        $permissions = $this->model->get()
            ->groupBy('group')->map(function ($group) {
                return $group->map(function ($value) {
                    return ['id' => $value->id, 'group' => $value->group,
                        'name' => $value->name, 'description' => $value->description];
                });
            });;

        return $permissions;
    }
}
