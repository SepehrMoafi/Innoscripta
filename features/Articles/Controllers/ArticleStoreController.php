<?php

namespace Features\Articles\Controllers;


use Features\Articles\ArticleResponses\Responses;
use Features\Articles\Requests\StoreArticle;
use Illuminate\Http\Request;
use Features\Articles\DB\ArticleStore;

class ArticleStoreController
{

    public function store(StoreArticle $request)
    {
        ArticleStore::store($request);
        return Responses::success();
    }

}
