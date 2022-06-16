<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Translation\TranslationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::group(['prefix' => 'admin', 'middleware' => ['web', 'is_admin']], function () {
    //// categories /////
    Route::get('/categories', [CategoryController::class,'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class,'create'])->name('category.index');
    Route::post('/categories/create', [CategoryController::class,'store'])->name('category.store');;
    Route::get('/categories/{id}/edit', [CategoryController::class,'edit'])->name('category.edit');;
    Route::post('/categories/update', [CategoryController::class,'update'])->name('category.update');;
    Route::post('/categories', [CategoryController::class,'destroy'])->name('category.destroy');;
    /// user and theri pets routes

    Route::get('/products', [ProductController::class,'index'])->name('product.index');
    Route::get('/products/create', [ProductController::class,'create'])->name('product.index');
    Route::post('/products/create', [ProductController::class,'store'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class,'edit'])->name('product.edit');
    Route::post('/products/update', [ProductController::class,'update'])->name('product.update');
    Route::post('/products', [ProductController::class,'destroy'])->name('product.destroy');

    Route::get('/translations', [TranslationController::class,'index']);
    Route::get('/translations/create', [TranslationController::class,'create'])->name('translation.index');
    Route::post('/translations/create', [TranslationController::class,'store'])->name('translation.store');
    Route::get('/translations/{id}/edit', [TranslationController::class,'edit'])->name('translation.edit');
    Route::post('/translations/update', [TranslationController::class,'update'])->name('translation.update');
    Route::post('/translations', [TranslationController::class,'destroy'])->name('translation.destory');

    Route::get('/users', [HomeController::class,'userList'])->name('user.list');



});

require __DIR__.'/auth.php';
