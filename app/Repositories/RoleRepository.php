<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;

/**
 * Class RoleRepository
 * @package App\Repositories
 */
class RoleRepository
{
    /**
     * @var Role
     */
    protected $model;

    /**
     * RoleRepository constructor.
     * @param Role $model
     */
    public function __construct(Role $model)
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
     * @return \Illuminate\Database\Eloquent\Collection|Role[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function find($data)
    {
        return $this->model->find($data);
    }

    /**
     * @return mixed
     */
    public function pluck()
    {
        return $this->model->pluck('name', 'id');
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
