<?php

namespace Features\Articles\Repositories;

use Features\Articles\Article;
use Illuminate\Contracts\Pagination\Paginator;

class ArticleRepository
{
    public function getArticles($specifications): Paginator
    {
        $query = Article::query()->with(['source','category']);
        foreach ($specifications as $specification) {
            $specification->apply($query);
        }
        return $query->simplePaginate(10);
    }
}
