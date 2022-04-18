<?php

namespace App\Repositories;

use App\Http\Filters\ArticleFilter;
use App\Models\Article;

/**
 * Class NewsRepository
 * @package App\Repositories
 */
class NewsRepository
{
    /**
     * @var Article
     */
    protected $model;

    /**
     * NewsRepository constructor.
     * @param Article $model
     */
    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getAllNewsCount()
    {
        return $this->model->count();
    }

    /**
     * @return mixed
     */
    public function getAllActiveNewsCount()
    {
        return $this->model->where('status', 'active')->count();
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
     * @param ArticleFilter $request
     * @param int $perPage
     * @return mixed
     */
    public function search(ArticleFilter $request, $perPage = 20)
    {
        return $this->model->sortable()
            ->filter($request)
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);
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
        return $this->show($id)->delete();
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
    public function save()
    {
        return $this->model->save();
    }

    /**
     * @param Article $model
     * @return $this
     */
    public function setModel(Article $model)
    {
        $this->model = $model;

        return $this;
    }
}
