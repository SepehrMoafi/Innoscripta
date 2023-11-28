<?php

namespace Features\Sources\SourceResponses;

use Illuminate\Support\Facades\Facade;

class Responses extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        $client = request('client');
        return [
            'api' => JsonResponseForSource::class,
            'web' => HtmlResponseForSource::class
        ][$client] ?? HtmlResponseForSource::class;
    }
}
