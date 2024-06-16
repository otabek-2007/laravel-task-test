<?php

use App\Http\Controllers\API\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("new-categories")->group(function () {
    Route::post('/store', [NewsController::class, 'storeCategory']);
    Route::get('/show', [NewsController::class, 'showCategories']);
    Route::post('/edit/{id}', [NewsController::class, 'updateCategory']);
    Route::post('/delete/{id}', [NewsController::class, 'destroyCategory']);
})->middleware('api:sanctum');

Route::prefix("news")->group(function () {
    Route::get('/show', [NewsController::class, 'showNews']);
    Route::post('/store', [NewsController::class, 'store']);
    Route::post('/edit/{id}', [NewsController::class, 'update']);
    Route::post('/delete/{id}', [NewsController::class, 'destroy']);
    Route::get('/show-item/{slug}', [NewsController::class, 'showItem']);
})->middleware('api:sanctum');


Route::get('index', [NewsController::class, 'index']);
