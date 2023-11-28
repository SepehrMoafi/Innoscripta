<?php

namespace Features\Categories\CategoriesResponses;

use Features\Categories\Category;


class HtmlResponseForCategoryStore
{
    public function allCategories()
    {
        $categories = Category::all();
        return view('Category::index', compact('categories'));
    }

    public function failed()
    {
        return to_route('categories.index')->with('error', 'category was not created');
    }

    public function success()
    {
        return to_route('categories.index')->with('success', 'category created successfully');
    }
}
