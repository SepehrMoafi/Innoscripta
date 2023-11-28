<?php

use Features\Articles\ArticleResponses\Responses;
use Features\Articles\Controllers\ArticleStoreController;
use Illuminate\Support\Facades\Route;

Route::get('articles', fn()=> Responses::allArticles())->name('index');

Route::post('articles', [ArticleStoreController::class, 'store'])->name('store');
