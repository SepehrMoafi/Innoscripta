<?php

namespace Features\Articles\services\FetchAndCreatePreData;

use App\Jobs\NewsApi\FetchNewsApiBasedOnQuery;
use Carbon\Carbon;
use Features\Articles\Article;
use Features\Articles\ArticleResponses\Responses;
use Features\Articles\DB\ArticleStore;
use Features\Articles\services\FetchAndCreatePreData\NewsServiceInterface\NewsServiceInterface;
use Features\Categories\Category;
use Features\Sources\Source;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsApiService implements NewsServiceInterface
{
    /**
     * Handles fetching articles from The NewsApi API based on a search query.
     * Utilizes a job dispatch system for asynchronous processing and stores the
     * fetched articles using the ArticleStore service.
     */

    private static int $pageSize = 5;

    public static function fetchArticles($search)
    {
        try {
            FetchNewsApiBasedOnQuery::dispatch(1,$search);

            $source = Source::query()->where('name', env('NEWSAPI_SOURCE_NAME', 'The NewsApi'))->first();
            if (!$source) {
                return;
            }
            $response = Http::timeout(60)->get($source->api_endpoint, [
                'q' => $search,
                'pageSize' => self::$pageSize,
                'apiKey' => $source->api_key,
            ]);

            if ($response->failed()) {
                Log::error('Failed to fetch articles from NewsAPI. Response: ' . $response->body());
                return;
            }

            $articles = $response->json()['articles'];

            foreach ($articles as $data) {
                $data = Article::newsApiData($data);
                ArticleStore::store($data,$source->id);
            }
        }catch (\Exception){
            Responses::failed();
        }
    }
}
