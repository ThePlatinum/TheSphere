<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\SourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(FeedController::class)->prefix('feed')->group(function () {
    Route::get('all', 'all');
    Route::get('popular', 'popular');
    Route::get('show/{slug}', 'show');
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'allCategories');
    Route::get('user/categories', 'userCategories');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('user/categories', 'store');
    });
});

Route::controller(SourceController::class)->group(function () {
    Route::get('sources', 'allSources');
    Route::get('user/sources', 'userSources');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('user/sources', 'store');
    });
});
