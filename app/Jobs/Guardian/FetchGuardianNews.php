<?php

namespace App\Jobs\Guardian;

use Carbon\Carbon;
use Features\Articles\Article;
use Features\Articles\DB\ArticleStore;
use Features\Categories\Category;
use Features\Sources\Source;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchGuardianNews implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $pageSize = 100;

    public function __construct(protected int $page = 1)
    {
        $this->onQueue('GuardianNews');
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle()
    {
        $source = Source::query()->where('name', env('GUARDIAN_SOURCE_NAME', 'The Guardian'))->first();
        if (!$source) {
            return;
        }

        try {
            $response = Http::timeout(60)->get($source->api_endpoint, [
                'api-key' => $source->api_key,
                'page-size' => $this->pageSize,
                'page' => $this->page,
            ]);
        } catch (ConnectException $e) {
            Log::error("Request to The Guardian API failed: " . $e->getMessage());
        }
        if ($response->failed()) {
            Log::error('Failed to fetch articles from The Guardian API. Response: ' . $response->body());
            return;
        }

        $response = $response->json()['response'];

        $articles = $response['results'];
        $totalPages = $response['pages'];

        foreach ($articles as $data) {
            $data = Article::guardianNewsData($data);
            ArticleStore::store($data, $source->id);
        }

        if ($this->page < $totalPages) {
            dispatch(new FetchGuardianNews($this->page + 1));
        }

    }

    /**
     * Handle a job failure.
     */
    public function failed(\Exception $exception)
    {
        Log::error("Job failed: " . $exception->getMessage());
    }
}

