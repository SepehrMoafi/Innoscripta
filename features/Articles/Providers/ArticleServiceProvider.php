<?php

namespace Features\Articles\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{

    public function register()
    {
    }

    public function boot()
    {

        $this->loadMigrationsFrom(base_path('features/Articles/migrations'));

        $this->loadViewsFrom(base_path('features/Articles/views'),'Article');

        Route::group(['as'=>'articles.'],base_path('features/Articles/routes/web.php'));
        Route::group(['as' => 'api.articles.'],base_path('features/Articles/routes/api.php'));

    }
}
