<?php

namespace Features\Articles\services\FetchAndCreatePreData;

use App\Jobs\NewsApi\FetchNewsApiBasedOnQuery;
use App\Jobs\NewsApiAi\FetchNewsApiAiBasedOnQuery;
use Carbon\Carbon;
use Features\Articles\Article;
use Features\Articles\ArticleResponses\Responses;
use Features\Articles\DB\ArticleStore;
use Features\Articles\services\FetchAndCreatePreData\NewsServiceInterface\NewsServiceInterface;
use Features\Categories\Category;
use Features\Sources\Source;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\String\s;

class NewsApiAiService implements NewsServiceInterface
{
    /**
     * Handles fetching articles from The NewsApiAi API based on a search query.
     * Utilizes a job dispatch system for asynchronous processing and stores the
     * fetched articles using the ArticleStore service.
     */

    private static int $pageSize = 5;

    public static function fetchArticles($search)
    {
        try {
            FetchNewsApiAiBasedOnQuery::dispatch(1, $search);
            $source = Source::query()->where('name', env('NEWSAPIAI_SOURCE_NAME', 'The NewsApiAi'))->first();
            if (!$source) {
                return;
            }
            $response = Http::timeout(60)->get($source->api_endpoint, [
                'action' => 'getArticles',
                'keyword' => $search,
                'articlesPage' => 1,
                'articlesCount' => self::$pageSize,
                'resultType' => 'articles',
                'apiKey' => $source->api_key,
            ]);
            if ($response->failed()) {
                Log::error('Failed to fetch articles from NewsAPI. Response: ' . $response->body());
                return;
            }

            $articles = $response->json()['articles']['results'];
            foreach ($articles as $data) {
                $data = Article::newsApiAiData($data);
                ArticleStore::store($data, $source->id);
            }
        } catch (\Exception $exception) {
            return Responses::failed();

        }
    }
}
