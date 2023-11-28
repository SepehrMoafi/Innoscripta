<?php

namespace Features\Sources\SourceResponses;

use Features\Articles\Repositories\ArticleRepository;
use Features\Articles\Specifications\AuthorSpecification;
use Features\Articles\Specifications\CategorySpecification;
use Features\Articles\Specifications\DateRangeSpecification;
use Features\Articles\Specifications\SearchSpecification;
use Features\Articles\Specifications\SourceSpecification;
use Features\Sources\Source;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class JsonResponseForSource
{
    public function allSources(Request $request): JsonResponse
    {
        $sources = Source::all();
        return response()->json($sources);
    }

    public function failed(): JsonResponse
    {
        return response()->json(['status' => 'error', 'message' => 'source was not created'], 500);
    }
}
