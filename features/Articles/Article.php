<?php

namespace Features\Articles;

use Carbon\Carbon;
use Features\Categories\Category;
use Features\Sources\Source;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class Article extends Model
{

    protected $fillable = ['title', 'author', 'source_id', 'category_id', 'published_at', 'content', 'url'];

    public static function schema()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->foreignId('source_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->dateTime('published_at')->nullable();
            $table->text('content')->nullable();
            $table->text('url')->nullable();
            $table->timestamps();

            $table->index('author');
            $table->index('published_at');
            $table->fullText(['title', 'content']);
        });
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function newsApiAiData($data): array
    {
        return [
            'categoryName' => $data['dataType'] ?? 'general',
            'url' => $data['url'] ?? 'general' . rand(1, 1000),
            'author' => array_key_exists('name', $data['authors']) ? $data['authors']['name'] : null,
            'title' => $data['title'],
            'published_at' => $data['date'],
            'content' => $data['body'],
        ];
    }

    public static function guardianNewsData($data): array
    {
        return [
            'categoryName' => $data['sectionName'],
            'url' => $data['webUrl'],
            'title' => $data['webTitle'],
            'published_at' => Carbon::parse($data['webPublicationDate'])->format('Y-m-d H:i:s'),
        ];
    }

    public static function newsApiData($data): array
    {
        return [
            'categoryName' => array_key_exists('name',$data['source']) ? $data['source']['name'] : 'general',
            'url' => $data['url'] ?? 'general'.rand(1,1000),
            'author' => $data['author'],
            'title' => $data['title'],
            'published_at' => Carbon::parse($data['publishedAt'])->format('Y-m-d H:i:s'),
            'content' => $data['content'],
        ];
    }
}
