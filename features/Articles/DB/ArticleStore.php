<?php

namespace Features\Articles\DB;

use Carbon\Carbon;
use Features\Articles\Article;
use Features\Articles\ArticleResponses\Responses;
use Features\Categories\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleStore
{
    public static function store($data, $sourceId)
    {
        try {
            DB::beginTransaction();
            $category = Category::firstOrCreate([
                'name' => $data['categoryName'],
                'source_id' => $sourceId,
            ]);

            $article = Article::updateOrCreate(
                ['url' => $data['url']],
                [
                    'title' => $data['title'] ?? null,
                    'author' => $data['author'] ?? null,
                    'source_id' => $sourceId,
                    'category_id' => $category->id,
                    'published_at' => $data['published_at'] ?? null,
                    'content' => $data['content'] ?? null,
                    'url' => $data['url'] ?? null,
                ]
            );


        } catch (\Exception $exception) {
            Log::critical('Article Error Is : ' . $exception->getMessage());
            DB::rollBack();
            return Responses::failed();
        }

        if (!$article->exists) {
            return Responses::failed();
        }
        DB::commit();
        return $article;
    }
}
