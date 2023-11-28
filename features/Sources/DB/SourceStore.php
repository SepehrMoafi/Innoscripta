<?php

namespace Features\Sources\DB;

use Features\Sources\Source;
use Features\Articles\ArticleResponses\Responses;
use Features\Articles\Requests\StoreArticle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SourceStore
{
    public static function store($data)
    {
        $source = Source::create($data);
        if (!$source->exists) {
            return Responses::failed();
        }
        return $source;
    }
}
