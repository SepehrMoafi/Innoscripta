<?php

use Features\Categories\Controllers\CategoryStoreController;
use Illuminate\Support\Facades\Route;

Route::post('categories', [CategoryStoreController::class, 'store'])->name('categories.store');
