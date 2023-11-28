<?php

namespace Features\Categories;

use Features\Articles\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class Category extends Model
{

    protected $fillable = ['name','source_id'];

    public static function schema()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('source_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

}
