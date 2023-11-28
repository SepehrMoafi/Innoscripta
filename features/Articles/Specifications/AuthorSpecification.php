<?php

namespace Features\Articles\Specifications;

use Illuminate\Database\Eloquent\Builder;

class AuthorSpecification
{
    public function __construct(protected $authorName)
    {
    }

    public function apply(Builder $query): void
    {
        if ($this->authorName) {
            $query->where('author', $this->authorName);
        }
    }
}
