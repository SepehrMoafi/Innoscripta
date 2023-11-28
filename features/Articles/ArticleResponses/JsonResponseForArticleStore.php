<?php

namespace Features\Articles\ArticleResponses;

use Features\Articles\Repositories\ArticleRepository;
use Features\Articles\Specifications\AuthorSpecification;
use Features\Articles\Specifications\CategorySpecification;
use Features\Articles\Specifications\DateRangeSpecification;
use Features\Articles\Specifications\SearchSpecification;
use Features\Articles\Specifications\SourceSpecification;
use Illuminate\Http\JsonResponse;
class JsonResponseForArticleStore
{
    public function __construct(protected ArticleRepository $articleRepository)
    {
    }

    /**
     * Retrieves articles based on search and filter criteria from the request.
     * Constructs specifications for each filter type and fetches articles via the repository.
     * Returns the resulting articles as a JSON response.
     */
    public function allArticles(): JsonResponse
    {
        $request = request();

        $specifications = [
            new SearchSpecification($request->input('search')),
            new DateRangeSpecification($request->input('from_date'), $request->input('to_date')),
            new SourceSpecification($request->input('source')),
            new CategorySpecification($request->input('category')),
            new AuthorSpecification($request->input('author'))
        ];

        $articles = $this->articleRepository->getArticles($specifications);

        return response()->json($articles);
    }

    public function failed(): JsonResponse
    {
        return response()->json(['status' => 'error', 'message' => 'article was not created'], 500);
    }
}
