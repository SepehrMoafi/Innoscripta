<?php

namespace Features\Categories\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadMigrationsFrom(base_path('features/Categories/migrations'));

        $this->loadViewsFrom(base_path('features/Categories/views'),'Category');

        Route::group(['as'=>'categories'],base_path('features/Categories/routes/web.php'));
        Route::group(['prefix' => 'api', 'as' => 'api.categories.'],base_path('features/Categories/routes/api.php'));

    }
}
