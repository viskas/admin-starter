<?php

namespace App\Http\Filters;

/**
 * Class NewsFilter
 * @package App\Http\Filters
 */
class ArticleFilter extends QueryFilter
{
    /**
     * @param $status
     */
    public function status($status)
    {
        $this->builder->where('status', $status);
    }

    /**
     * @param $title
     */
    public function title($title)
    {
        $this->builder->where('title', 'like', '%'.$title.'%');
    }

    /**
     * @param $slug
     */
    public function slug($slug)
    {
        $this->builder->where('slug', 'like', '%'.$slug.'%');
    }

    /**
     * @param $search
     */
    public function search($search)
    {
        $this->builder->orWhere('title', 'LIKE', "%{$search}%");
        $this->builder->orWhere('slug', 'LIKE', "%{$search}%");
        $this->builder->orWhere('id', $search);
    }
}
