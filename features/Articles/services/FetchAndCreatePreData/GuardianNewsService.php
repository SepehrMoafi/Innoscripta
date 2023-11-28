<?php

namespace Features\Articles\services\FetchAndCreatePreData;

use App\Jobs\Guardian\FetchGuardianNewsBasedOnQuery;
use Carbon\Carbon;
use Features\Articles\Article;
use Features\Articles\DB\ArticleStore;
use Features\Articles\services\FetchAndCreatePreData\NewsServiceInterface\NewsServiceInterface;
use Features\Categories\Category;
use Features\Sources\Source;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GuardianNewsService implements NewsServiceInterface
{
    /**
     * Handles fetching articles from The Guardian API based on a search query.
     * Utilizes a job dispatch system for asynchronous processing and stores the
     * fetched articles using the ArticleStore service.
     */

    private static int $pageSize = 5;

    public static function fetchArticles($search)
    {
        FetchGuardianNewsBasedOnQuery::dispatch(1, $search);

        $source = Source::query()->where('name', env('GUARDIAN_SOURCE_NAME', 'The Guardian'))->first();
        if (!$source) {
            return;
        }
        $response = Http::timeout(60)->get($source->api_endpoint, [
            'q' => $search,
            'page-size' => self::$pageSize,
            'api-key' => $source->api_key,
        ]);
        if ($response->failed()) {
            Log::error('Failed to fetch articles from The Guardian API. Response: ' . $response->body());
            return;
        }
        $response = $response->json()['response'];

        $articles = $response['results'];

        foreach ($articles as $data) {
            $data = Article::guardianNewsData($data);
            ArticleStore::store($data, $source->id);
        }
    }
}
