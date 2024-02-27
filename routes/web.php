<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductsController::class, 'create'])->name('products.create');//->middleware(['auth', 'admin']);
    Route::post('/', [ProductsController::class, 'store'])->name('products.store');//->middleware(['auth','admin']);
    Route::get('/{product}', [ProductsController::class, 'show'])->name('products.show');
    Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');//->middleware(['auth','admin']);
    Route::put('/{product}', [ProductsController::class, 'update'])->name('products.update');//->middleware(['auth','admin']);
    Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');//->middleware(['auth','admin']);
    Route::get('/{product}/edit-image', [ProductsController::class, 'editImage'])->name('products.editImage');//->middleware(['auth','admin']);
    Route::patch('/{product}/edit-image', [ProductsController::class, 'updateImage'])->name('products.updateImage');//->middleware(['auth','admin']);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');//->middleware(['auth', 'admin']);
    Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');//->middleware(['auth', 'admin']);
    Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');//->middleware(['auth','admin']);
    Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');//->middleware(['auth','admin']);
    Route::put('/{category}', [CategoriesController::class, 'update'])->name('categories.update');//->middleware(['auth','admin']);
    Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');//->middleware(['auth','admin']);
});

//Auth::routes();

//Route::get('/home', [HomeController::class, 'index'])->name('home');

