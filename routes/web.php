<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangesController;
use App\Http\Controllers\DocumentController;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('auth.login');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::get('/', function () {
        return view('dashboard');
    })->name('/');

    Route::resource('/documents', DocumentController::class)->only('index');
    Route::resource('/changes', ChangesController::class)->only('index', 'show');

});
