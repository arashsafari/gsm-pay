<?php


use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CRUD Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PostController::class, 'index'])
    ->name('index');

Route::get('/{id}', [PostController::class, 'show'])
    ->name('show');

