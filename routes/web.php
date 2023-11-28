<?php

use App\Jobs\NewsApiAi\FetchNewsApiAiBasedOnQuery;
use Illuminate\Support\Facades\Route;
Route::get('/',function (){
    FetchNewsApiAiBasedOnQuery::dispatch(1,'debate');
});
