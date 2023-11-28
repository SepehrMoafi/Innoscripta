<?php

namespace Features\Articles\Specifications;

use Carbon\Carbon;
use Features\Articles\Article;
use Features\Categories\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;

class CreatePreData
{

    public function __construct(protected $searchTerm)
    {
    }

    public function apply(Builder $query): void
    {
        $response = Http::timeout(60)->get('https://newsapi.org/v2/everything', [
            'apiKey' => '044c33f469bd48cab24c212ec728a327',
            'q' => 'apple',
        ]);
        $articles = $response->json()['articles'];
        $articles = array_slice($articles, 0, 5);
        foreach ($articles as $articleData) {
            $this->storeArticle($articleData, 5);
        }

        if ($this->searchTerm) {
            $query->where(function($query) {
                $query->where('title', 'LIKE', "%{$this->searchTerm}%")
                    ->orWhere('content', 'LIKE', "%{$this->searchTerm}%")
                    ->orWhere('author', 'LIKE', "%{$this->searchTerm}%");
            });
        }
    }

    protected function storeArticle($data, $sourceId)
    {
        $category = Category::firstOrCreate([
            'name' => array_key_exists('name',$data['source']) ? $data['source']['name'] : 'general',
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
}
