<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $repository
     * @param UploadService $uploadService
     */
    public function __construct(CategoryRepository $repository, UploadService $uploadService)
    {
        $this->repository = $repository;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function getTree()
    {
        return $this->repository->get()->toTree();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $category =  $this->repository->create($data);

        if (!$category) {
            return false;
        }

        if (isset($data['image'])) {
            $picture = $this->uploadService->saveFile('public/categories/'.$category->id.'/', $data['image']);
            $this->repository->setModel($category)
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
        $category = $this->repository->getById($id);

        $updatedCategory = $this->repository->setModel($category)
            ->fill($data)
            ->update();

        if (!$updatedCategory) {
            return false;
        }

        if (isset($data['image'])) {
            $picture = $this->uploadService->updateFile('public/categories/'.$category->id.'/', $data['image'], $category->image);
            $this->repository->setModel($category)
                ->fill(['image' => $picture])
                ->update();
        }

        return true;
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
