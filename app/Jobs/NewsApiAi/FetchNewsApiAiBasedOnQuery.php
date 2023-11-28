<?php

namespace App\Jobs\NewsApiAi;

use App\Jobs\Guardian\FetchGuardianNews;
use Carbon\Carbon;
use Features\Articles\Article;
use Features\Articles\DB\ArticleStore;
use Features\Categories\Category;
use Features\Sources\Source;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsApiAiBasedOnQuery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected int $pageSize = 50;

    public function __construct(protected $page = 1, protected $search)
    {
        $this->onQueue('NewsApiAiBasedOnQuery');
    }

    public function handle()
    {
        $source = Source::query()->where('name', env('NEWSAPIAI_SOURCE_NAME', 'The NewsApiAi'))->first();

        if (!$source) {
            return;
        }
        try {
            $response = Http::timeout(60)->get($source->api_endpoint, [
                'action' => 'getArticles',
                'keyword' => $this->search,
                'articlesPage' => 1,
                'articlesCount' => $this->pageSize,
                'resultType' => 'articles',
                'apiKey' => $source->api_key,
            ]);

        } catch (ConnectException $e) {
            Log::error("Request to The NewsApiAi failed: " . $e->getMessage());
            return;
        }
        if ($response->failed()) {
            Log::error('Failed to fetch articles from The NewsApiAi. Response: ' . $response->body());
            return;
        }
        $articles = $response->json()['articles'];

        $totalPages = $articles['pages'];

        $results = $articles['results'];

        foreach ($results as $result) {
            $result = Article::newsApiAiData($result);
            ArticleStore::store($result,$source->id);
        }

        if ($this->page < $totalPages) {
            dispatch(new FetchNewsApiAiBasedOnQuery($this->page + 1,$this->search));
        }

    }
    /**
     * Handle a job failure.
     */
    public function failed(\Exception $exception)
    {
        Log::error("Job FetchNewsApiAi failed: " . $exception->getMessage());
    }
}
