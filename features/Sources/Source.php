<?php

namespace Features\Sources;

use Features\Articles\Article;
use Features\Categories\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class Source extends Model
{

    protected $fillable = ['name', 'api_endpoint', 'api_key'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public static function schema()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('api_endpoint')->unique();
            $table->string('api_key')->nullable();
            $table->timestamps();
        });
    }
}
