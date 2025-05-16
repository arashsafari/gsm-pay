<?php


use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CRUD Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', LoginController::class)
    ->name('login');

