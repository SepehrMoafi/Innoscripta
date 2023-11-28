<?php

namespace App\Jobs\NewsApi;

use App\Jobs\Guardian\FetchGuardianNews;
use Carbon\Carbon;
use Features\Articles\Article;
use Features\Categories\Category;
use Features\Sources\Source;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchNewsApiBasedOnQuery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected int $pageSize = 50;

    public function __construct(protected $page = 1, protected $search)
    {
        $this->onQueue('NewsApiBasedOnQuery');

    }

    public function handle()
    {
        $source = Source::query()->where('name', env('NEWSAPI_SOURCE_NAME', 'The NewsApi'))->first();
        if (!$source) {
            return;
        }

        try {
            $response = Http::timeout(60)->get($source->api_endpoint, [
                'apiKey' => $source->api_key,
                'q' => $this->search,
                'pageSize' => $this->pageSize,
                'page' => $this->page,
            ]);
        } catch (ConnectException $e) {
            Log::error("Request to The NewsApi failed: " . $e->getMessage());
        }
        if ($response->failed()) {
            Log::error('Failed to fetch articles from The NewsApi. Response: ' . $response->body());
            return;
        }
        $articles = $response->json()['articles'];

        $totalPages = $response['totalResults'] / $this->pageSize;

        foreach ($articles as $articleData) {
            $this->storeArticle($articleData, $source->id);
        }

        if ($this->page < $totalPages) {
            dispatch(new FetchGuardianNews($this->page + 1));
        }

    }

    protected function storeArticle($data, $sourceId)
    {
        $category = Category::firstOrCreate([
            'name' => array_key_exists('name', $data['source']) ? $data['source']['name'] : 'general',
            'source_id' => $sourceId,
        ]);

        Article::updateOrCreate(
            ['url' => $data['url']],
            [
                'title' => $data['title'],
                'author' => $data['author'],
                'source_id' => $sourceId,
                'category_id' => $category->id,
                'published_at' => Carbon::parse($data['publishedAt'])->format('Y-m-d H:i:s'),
                'content' => $data['content'],
                'url' => $data['url'],
            ]
        );
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Exception $exception)
    {
        Log::error("Job failed: " . $exception->getMessage());
    }
}
