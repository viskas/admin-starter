<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\ArticleFilter;
use App\Http\Requests\Admin\News\CreateNewsRequest;
use App\Http\Requests\Admin\News\UpdateNewsRequest;
use App\Services\NewsService;

/**
 * Class NewsController
 * @package App\Http\Controllers\Admin
 */
class NewsController extends Controller
{
    /**
     * @var NewsService
     */
    protected $newsService;

    /**
     * NewsController constructor.
     * @param NewsService $newsService
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @param ArticleFilter $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(ArticleFilter $request)
    {
        $articles = $this->newsService->search($request);

        return view('admin.news.index', compact('articles'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * @param CreateNewsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateNewsRequest $request)
    {
        if (!$this->newsService->create($request->all())) {
            return redirect()->route('admin.news.index')->with('error', __('Error. Failed to add news.'));
        }

        return redirect()->route('admin.news.index')->withSuccess(__('The news has been successfully added.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $article = $this->newsService->getArticleById($id);

        return view('admin.news.edit', compact('article'));
    }

    /**
     * @param UpdateNewsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateNewsRequest $request, $id)
    {
        if (!$this->newsService->update($request->all(), $id)) {
            return redirect()->route('admin.news.index')->with('error', __('Error. Failed to save data.'));
        }

        return redirect()->route('admin.news.index')->with('success', __('Changes saved.'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $this->newsService->delete($id);

        return back()->with('success', __('The news has been successfully removed!'));
    }
}
