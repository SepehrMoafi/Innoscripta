<?php

namespace Features\Articles\Specifications;

use Illuminate\Database\Eloquent\Builder;

class DateRangeSpecification
{
    public function __construct(protected $fromDate, protected $toDate)
    {
    }

    public function apply(Builder $query): void
    {
        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('published_at', [$this->fromDate, $this->toDate]);
        }
    }
}
