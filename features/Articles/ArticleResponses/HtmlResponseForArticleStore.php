<?php

namespace Features\Articles\ArticleResponses;

use Features\Articles\Article;
use Illuminate\View\View;

class HtmlResponseForArticleStore
{
    public function allArticles(): View
    {
        $articles = Article::all();
        return view('Article::index', compact('articles'));
    }

    public function failed()
    {
        return redirect()->back()->with(['error' => 'something is wrong']);
    }
}
