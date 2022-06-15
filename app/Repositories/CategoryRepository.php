<?php

namespace App\Repositories;

use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository
{
    /**
     * @var Category
     */
    protected $model;

    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fill(array $data)
    {
        $this->model->fill($data);

        return $this;
    }

    /**
     * @return bool
     */
    public function update()
    {
        return $this->model->update();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * @param Category $model
     * @return $this
     */
    public function setModel(Category $model)
    {
        $this->model = $model;

        return $this;
    }
}
