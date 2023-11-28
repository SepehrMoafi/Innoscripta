<?php

namespace Features\Categories\DB;

use Features\Categories\CategoriesResponses\Responses;
use Features\Categories\Category;

class CategoryStore
{
    public static function store($data)
    {
        $category = Category::create($data);

        if (!$category->exists) {
            return Responses::failed();
        }

        return $category;
    }
}
