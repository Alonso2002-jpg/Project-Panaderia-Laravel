<?php

use App\Http\Controllers\staffController;
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
Route::group(['prefix' => 'staff'], function () {
    Route::get('/', [staffController::class, 'index']);
    Route::get('/create', [staffController::class, 'create']);
    Route::post('/', [staffController::class, 'store']);
    Route::get('/{id}', [staffController::class, 'show']);
    Route::get('/{id}/edit', [staffController::class, 'edit']);
    Route::put('/{id}', [staffController::class, 'update']);
    Route::delete('/{id}', [staffController::class, 'destroy']);
    Route::get('/{id}/editImage', [staffController::class, 'editImage']);
    Route::put('/{id}/updateImage', [staffController::class, 'updateImage']);
    Route::put('/{id}/recover', [staffController::class, 'recover']);
});
