<?php

namespace Features\Categories\Controllers;


use Features\Categories\CategoriesResponses\Responses;
use Features\Categories\DB\CategoryStore;

class CategoryStoreController
{
    public function store()
    {
        $data =request()->only(['name']);
        CategoryStore::store($data);
        return Responses::success();
    }
}
