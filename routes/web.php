<?php

use Illuminate\Support\Facades\Route;
use \App\Mail\MailableController;
use \App\Mail\BillMailable;
use \App\Mail\ForgotPassMailable;
use \App\Mail\RegisterMailable;
use \Illuminate\Support\Facades\Mail;
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
    return view('index');
});

Route::group(['prefix' => 'email'],function () {
    Route::get('/register/{email}', [MailableController::class, 'sendRegister'])->name('email.register');
    Route::get('/invoice/{email}', [MailableController::class, 'sendInVoice'])->name('email.invoice');
    Route::get('/forgot/{email}',  [MailableController::class, 'sendForgotPass'])->name('email.forgot');
});
