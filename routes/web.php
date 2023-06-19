<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {
    return redirect(route('service.index'));
});

Route::middleware("guest")->group(function() {
    Route::get('/login',          [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login_process', [AuthController::class, 'loginProcess'])->name('login_process');
});
Route::get('/register',          [AuthController::class, 'registerForm'])->name('register');
Route::post('/register_process', [AuthController::class, 'registerProcess'])->name('register_process');

Route::middleware("auth")->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resources([
        '/service'  => ServiceController::class,
        '/category' => CategoryController::class,
        '/users'    => UserController::class,
    ]);
});
Auth::routes();
Route::post('/save-token', [App\Http\Controllers\ServiceController::class, 'saveToken'])->name('save-token');
Route::post('/send-notification', [App\Http\Controllers\ServiceController::class, 'sendNotification'])->name('send.notification');
