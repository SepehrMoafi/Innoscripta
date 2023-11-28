<?php

namespace Features\Articles\Specifications;

use Illuminate\Database\Eloquent\Builder;

class CategorySpecification
{
    public function __construct(protected $categoryName)
    {
    }

    public function apply(Builder $query): void
    {
        if ($this->categoryName) {
            $query->whereHas('category', function($query) {
                $query->where('name', 'LIKE', "%{$this->categoryName}%");
            });
        }
    }
}
