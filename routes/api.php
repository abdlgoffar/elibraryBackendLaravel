<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookImageController;
use App\Http\Controllers\BookPortableDocFormatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureTokenIsValid;
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



Route::post('/users/signup', [UserController::class, 'register']);

Route::post('/users/auth', [AuthController::class, 'auth']);


Route::get('/books', [BookController::class, 'getAll']);
Route::get('/books/categories/{id}', [BookController::class, 'getByCategoryId']);
Route::get('/categories', [CategoryController::class, 'getAll']);




Route::middleware([EnsureTokenIsValid::class])->group(function () {

    Route::get('/users', [UserController::class, 'get']);

    Route::delete('/users/logout', [AuthController::class, 'out']);


    Route::get('/categories/{id}', [CategoryController::class, 'getById']);
    Route::put('/categories/{id}', [CategoryController::class, 'updateById']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteById']);



    Route::get('/books/{id}', [BookController::class, 'getById']);
    Route::get('/books/users/{id}', [BookController::class, 'getByUserId']);
    Route::put('/books/{id}', [BookController::class, 'updateById']);
    Route::post('/books', [BookController::class, 'store']);
    Route::delete('/books/{id}', [BookController::class, 'deleteById']);

    Route::post('/books/img/upload', [BookImageController::class, 'upload']);
    Route::get('/books/img/download/{name}', [BookImageController::class, 'download']);
    Route::get('/books/img/{id}', [BookImageController::class, 'getById']);

    Route::post('/books/pdf/upload', [BookPortableDocFormatController::class, 'upload']);
    Route::get('/books/pdf/download/{name}', [BookPortableDocFormatController::class, 'download']);
});
