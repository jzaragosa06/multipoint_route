<?php

use App\Http\Controllers\DBController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ShowPageController;
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

Route::get('/', [ShowPageController::class, 'landing'])->name('landing');

Route::get('/index', [ShowPageController::class, 'index'])->name('index')->middleware('checkuser');

Route::post('/proxy', [MapController::class, 'proxy'])->name('proxy');
Route::post('/save-location', [DBController::class, 'save_location'])->name('save-location');
Route::get('/history', [DBController::class, 'history'])->name('history')->middleware('checkuser');

Route::get('/login', [ShowPageController::class, 'login'])->name('login');
Route::get('/register', [ShowPageController::class, 'register'])->name('register');
Route::post('/login_submit', [DBController::class, 'login_submit'])->name('login_submit');
Route::post('/register_submit', [DBController::class, 'register_submit'])->name('register_submit');
Route::get('/logout', [DBController::class, 'logout'])->name('logout');
