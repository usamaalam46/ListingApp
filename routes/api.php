<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Translation\TranslationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group( function () {
    
    Route::post('update-profile', [UserController::class,'updateUser']);

    Route::get('category',[CategoryController::class,'list']);

    Route::get('product',[ProductController::class,'list']);

    Route::post('search',[ProductController::class,'search']);

    Route::post('filter-translation',[TranslationController::class,'filterTranslation']);

});

Route::post('/register', [UserController::class,'Register']);
Route::post('/login', [UserController::class,'login']);
