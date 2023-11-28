<?php

namespace Features\Sources\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SourceServiceProvider extends ServiceProvider
{

    public function register()
    {
    }

    public function boot()
    {

        $this->loadMigrationsFrom(base_path('features/Sources/migrations'));

        $this->loadViewsFrom(base_path('features/Sources/views'),'Source');

        Route::group(['as'=>'sources'],base_path('features/Sources/routes/web.php'));
        Route::group(['prefix' => 'api', 'as' => 'api.sources.'],base_path('features/Sources/routes/api.php'));

    }
}
