<?php

use App\Http\Controllers\CategoriesController;
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

