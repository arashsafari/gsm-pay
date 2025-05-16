<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserMostViewedPostsController;
use App\Http\Controllers\User\UploadProfileImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CRUD Routes
|--------------------------------------------------------------------------
*/
Route::post('/upload-profile-image', UploadProfileImageController::class)
    ->middleware('auth:api')
    ->name('upload-profile-image');

Route::get('/most-viewed-posts', UserMostViewedPostsController::class)
    ->name('most-viewed-posts');

