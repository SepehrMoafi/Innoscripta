<?php

namespace Features\Articles\ArticleResponses;

use Illuminate\Support\Facades\Facade;

class Responses extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        $client = request('client');
        return [
            'api' => JsonResponseForArticleStore::class,
            'web' => HtmlResponseForArticleStore::class
        ][$client] ?? HtmlResponseForArticleStore::class;
    }
}
