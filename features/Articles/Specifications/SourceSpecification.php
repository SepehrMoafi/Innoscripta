<?php

namespace Features\Articles\Specifications;

use Illuminate\Database\Eloquent\Builder;

class SourceSpecification
{
    public function __construct(protected $sourceName)
    {
    }

    public function apply(Builder $query): void
    {
        if ($this->sourceName) {
            $query->whereHas('source', function($query) {
                $query->where('name', 'LIKE', "%{$this->sourceName}%");
            });
        }
    }
}
