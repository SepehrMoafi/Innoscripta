<?php

namespace Features\Sources\Controllers;


use Features\Articles\ArticleResponses\Responses;
use Features\Sources\DB\SourceStore;

class SourceStoreController
{
    public function store()
    {
        SourceStore::store(request()->all());
        return Responses::success();
    }

}
