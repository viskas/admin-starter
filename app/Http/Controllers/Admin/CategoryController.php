<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Categories\CreateCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Services\CategoryService;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    protected $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $nodes = $this->categoryService->getTree();

        return view('admin.category.index', compact('nodes'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $nodes = $this->categoryService->getTree();

        return view('admin.category.create', compact('nodes'));
    }

    public function store(CreateCategoryRequest $request)
    {
        if (!$this->categoryService->create($request->all())) {
            return redirect()->route('admin.categories.index')->with('error', __('Error. Failed to add new category.'));
        }

        return redirect()->route('admin.categories.index')->with('success', __('The category has been successfully added.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $nodes = $this->categoryService->getTree();
        $category = $this->categoryService->getCategoryById($id);

        return response()->json([
            'form' => view('admin.category._edit', compact('nodes', 'category'))->render()
        ]);
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        if (!$this->categoryService->update($request->all(), $id)) {
            $request->session()->flash('error', __('Error. Failed to save data.'));
        }

        $request->session()->flash('success', __('Changes saved.'));

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);

        return back()->with('success', __('The category has been successfully removed!'));
    }
}
