<?php

namespace Features\Articles\Specifications;

use Features\Articles\services\FetchAndCreatePreData\GuardianNewsService;
use Features\Articles\services\FetchAndCreatePreData\NewsApiAiService;
use Features\Articles\services\FetchAndCreatePreData\NewsApiService;
use Illuminate\Database\Eloquent\Builder;

class SearchSpecification
{

    public function __construct(protected $searchTerm)
    {
    }

    public function apply(Builder $query): void
    {
        if ($this->searchTerm) {
            GuardianNewsService::fetchArticles($this->searchTerm);
            NewsApiService::fetchArticles($this->searchTerm);
            NewsApiAiService::fetchArticles($this->searchTerm);
            $query->where(function($query) {
                $query->where('title', 'LIKE', "%{$this->searchTerm}%")
                    ->orWhere('content', 'LIKE', "%{$this->searchTerm}%")
                    ->orWhere('author', 'LIKE', "%{$this->searchTerm}%");
            });
        }
    }
}
