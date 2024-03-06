<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\staffController;
use App\Mail\MailableController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
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
    $categories = Category::all();
    return view('index')->with('categories', $categories);
})->name('home');

Route::group(['prefix' => 'cart'], function () {
   Route::get('/', [CartController::class, 'showCart'])->name('cart')->middleware(['auth','admin']);
   Route::put('/', [CartController::class, 'updateCartLine'])->name('cart.update')->middleware(['auth','admin']);
   Route::delete('/', [CartController::class, 'destroyCartLine'])->name('cart.destroy')->middleware(['auth','admin']);
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductsController::class, 'create'])->name('products.create')->middleware(['auth', 'admin']);
    Route::post('/', [ProductsController::class, 'store'])->name('products.store')->middleware(['auth','admin']);
    Route::get('/{product}', [ProductsController::class, 'show'])->name('products.show');
    Route::post('/{product}', [ProductsController::class, 'addToCart'])->name('addToCart')->middleware(['auth']);
    Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit')->middleware(['auth','admin']);
    Route::put('/{product}', [ProductsController::class, 'update'])->name('products.update')->middleware(['auth','admin']);
    Route::delete('/{product}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware(['auth','admin']);
    Route::get('/{product}/edit-image', [ProductsController::class, 'editImage'])->name('products.editImage')->middleware(['auth','admin']);
    Route::patch('/{product}/edit-image', [ProductsController::class, 'updateImage'])->name('products.updateImage')->middleware(['auth','admin']);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoriesController::class, 'index'])->name('categories.index')->middleware(['auth', 'admin']);
    Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create')->middleware(['auth', 'admin']);
    Route::post('/', [CategoriesController::class, 'store'])->name('categories.store')->middleware(['auth','admin']);
    Route::get('/{category}', [CategoriesController::class, 'show'])->name('categories.show');
    Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit')->middleware(['auth','admin']);
    Route::put('/{category}', [CategoriesController::class, 'update'])->name('categories.update')->middleware(['auth','admin']);
    Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy')->middleware(['auth','admin']);
    Route::get('/{category}/edit-image', [CategoriesController::class, 'editImage'])->name('categories.editImage')->middleware(['auth','admin']);
    Route::patch('/{category}/edit-image', [CategoriesController::class, 'updateImage'])->name('categories.updateImage')->middleware(['auth','admin']);
});

Route::group(['prefix' => 'providers'], function () {
    Route::get('/', [ProvidersController::class, 'index'])->name('providers.index')->middleware(['auth', 'admin']);
    Route::get('/create', [ProvidersController::class, 'create'])->name('providers.create')->middleware(['auth', 'admin']);
    Route::post('/', [ProvidersController::class, 'store'])->name('providers.store')->middleware(['auth','admin']);
    Route::get('/{provider}/edit', [ProvidersController::class, 'edit'])->name('providers.edit')->middleware(['auth','admin']);
    Route::put('/{provider}', [ProvidersController::class, 'update'])->name('providers.update')->middleware(['auth','admin']);
    Route::delete('/{provider}', [ProvidersController::class, 'destroy'])->name('providers.destroy')->middleware(['auth','admin']);
});
Route::group(['prefix' => 'staff'], function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff.index')->middleware(['auth', 'admin']);
    Route::get('/create', [StaffController::class, 'create'])->name('staff.create')->middleware(['auth', 'admin']);
    Route::post('/', [StaffController::class, 'store'])->name('staff.store')->middleware(['auth', 'admin']);
    Route::get('/{staff}', [StaffController::class, 'show'])->name('staff.show')->middleware(['auth', 'admin']);
    Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit')->middleware(['auth', 'admin']);
    Route::put('/{staff}', [StaffController::class, 'update'])->name('staff.update')->middleware(['auth', 'admin']);
    Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy')->middleware(['auth', 'admin']);
    Route::get('/{staff}/edit-image', [StaffController::class, 'editImage'])->name('staff.editImage')->middleware(['auth', 'admin']);
    Route::patch('/{staff}/update-image', [StaffController::class, 'updateImage'])->name('staff.updateImage')->middleware(['auth', 'admin']);
    Route::post('/{staff}/recover', [StaffController::class, 'recover'])->name('staff.recover')->middleware(['auth', 'admin']);
});
Route::group(['prefix' => 'gestion'], function () {
    Route::get('/products', [ProductsController::class, 'products'])->name('gestion.products')->middleware(['auth', 'admin']);
    Route::get('/providers', [ProvidersController::class, 'index'])->name('gestion.providers')->middleware(['auth', 'admin']);
    Route::get('/staff', [staffController::class, 'staff'])->name('gestion.staff')->middleware(['auth', 'admin']);
    Route::get('/categories', [CategoriesController::class, 'categories'])->name('gestion.categories')->middleware(['auth', 'admin']);

});

Route::group(['prefix' => 'email'], function () {
    Route::get('/register/{email}', [MailableController::class, 'sendRegister'])->name('email.register');
    Route::get('/invoice/{email}', [MailableController::class, 'sendInVoice'])->name('email.invoice');
    Route::get('/forgot/{email}', [MailableController::class, 'sendForgotPass'])->name('email.forgot');
});
Route::get('/about', function () { return view('about'); })->name('about');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

