<?php

namespace Features\Categories\CategoriesResponses;

use Illuminate\Support\Facades\Facade;

class Responses extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        $client=request('client');
        return [
            'api'=>JsonResponseForCategoryStore::class,
            'web'=>HtmlResponseForCategoryStore::class
        ][$client] ?? HtmlResponseForCategoryStore::class;
    }
}
