<?php

namespace Features\Categories\CategoriesResponses;

use Features\Categories\Category;

class JsonResponseForCategoryStore
{
    public function allCategories()
    {
        $categories = Category::all();
        return response()->json($categories,200);
    }

    public function failed()
    {
        return response()->json(['status' => 'error', 'message' => 'category was not created'], 500);
    }

    public function success()
    {
        return response()->json(['status' => 'success', 'message' => 'category created successfully'], 200);
    }
}
