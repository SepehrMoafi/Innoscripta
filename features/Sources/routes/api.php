<?php

use Features\Sources\Controllers\SourceStoreController;
use Features\Sources\SourceResponses\Responses;
use Illuminate\Support\Facades\Route;

Route::get('sources', fn()=> Responses::allSources())->name('index');

Route::post('sources', [SourceStoreController::class, 'store'])->name('store');
