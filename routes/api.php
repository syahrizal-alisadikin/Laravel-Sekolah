<?php

use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PhotoController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\VideoController;
use App\Http\Controllers\API\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/kelas', [AuthController::class, 'kelas']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

//posts
Route::get('/post', [PostController::class, 'index']);
Route::get('/post/{id?}', [PostController::class, 'show']);
Route::get('/homepage/post', [PostController::class, 'PostHomePage']);

//events
Route::get('/event', [EventController::class, 'index']);
Route::get('/event/{slug?}', [EventController::class, 'show']);
Route::get('/homepage/event', [EventController::class, 'EventHomePage']);

//slider
Route::get('/slider', [SliderController::class, 'index']);

//tags
Route::get('/tag', [TagController::class, 'index']);
Route::get('/tag/{slug?}', [TagController::class, 'show']);

//category
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug?}', [CategoryController::class, 'show']);

//photo
Route::get('/photo', [PhotoController::class, 'index']);
Route::get('/homepage/photo', [PhotoController::class, 'PhotoHomepage']);

//video
Route::get('/video', [VideoController::class, 'index']);
Route::get('/homepage/video', [VideoController::class, 'VideoHomepage']);

// Friend List
Route::get('/friend', [SiswaController::class, 'friend'])->middleware('auth:sanctum');
Route::get('/transactions', [SiswaController::class, 'transaction'])->middleware('auth:sanctum');
Route::delete('/transactions/{id}', [SiswaController::class, 'DeleteTransaction'])->middleware('auth:sanctum');

Route::get('/tagihan', [SiswaController::class, 'tagihan']);
Route::get('/tagihan/{id}', [SiswaController::class, 'detailTagihan']);
Route::post('/tagihan/store', [SiswaController::class, 'store'])->middleware('auth:sanctum');
Route::post('/midtrans/callback', [SiswaController::class, 'callback']);
