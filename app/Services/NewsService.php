<?php

namespace App\Services;

use App\Http\Filters\ArticleFilter;
use App\Repositories\NewsRepository;

/**
 * Class NewsService
 * @package App\Services
 */
class NewsService
{
    /**
     * @var NewsRepository
     */
    protected $repository;

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * NewsService constructor.
     * @param NewsRepository $repository
     * @param UploadService $uploadService
     */
    public function __construct(NewsRepository $repository, UploadService $uploadService)
    {
        $this->repository = $repository;
        $this->uploadService = $uploadService;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function search(ArticleFilter $request)
    {
        $perPage = $request->getRequest()->per_page ?: 20;

        return $this->repository->search($request, $perPage);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $article =  $this->repository->create($data);

        if (!$article) {
            return false;
        }

        if (isset($data['file'])) {
            $picture = $this->uploadService->saveFile('public/news/'.$article->id.'/', $data['file']);
            $this->repository->setModel($article)
                ->fill(['image' => $picture])
                ->update();
        }

        return true;
    }

    /**
     * @param array $data
     * @param $id
     * @return bool
     */
    public function update(array $data, $id)
    {
        $article = $this->repository->show($id);

        $updatedArticle = $this->repository->setModel($article)
            ->fill($data)
            ->update();

        if (!$updatedArticle) {
            return false;
        }

        if (isset($data['file'])) {
            $picture = $this->uploadService->updateFile('public/news/'.$article->id.'/', $data['file'], $article->image);
            $this->repository->setModel($article)
                ->fill(['image' => $picture])
                ->update();
        }

        return true;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getArticleById($id)
    {
        return $this->repository->show($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
