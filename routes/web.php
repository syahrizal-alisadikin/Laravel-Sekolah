<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\KelasController;
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

Route::get('/', function () {
    return view('welcome');
});
//log-viewers
Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::prefix('admin')->group(function () {

    Route::group(['middleware' => 'auth'], function(){

        //dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

        //permissions
        Route::resource('/permission', PermissionController::class, ['except' => ['show', 'create', 'edit', 'update', 'delete'] ,'as' => 'admin']);
    
        //roles
        Route::resource('/role', RoleController::class, ['except' => ['show'] ,'as' => 'admin']);

        //users
        Route::resource('/user', UserController::class, ['except' => ['show'] ,'as' => 'admin']);

        //tags
        Route::resource('/tag', TagController::class, ['except' => 'show' ,'as' => 'admin']);

        //categories
        Route::resource('/category', CategoryController::class, ['except' => 'show' ,'as' => 'admin']);

        //posts
        Route::resource('/post', PostController::class, ['except' => 'show' ,'as' => 'admin']);

        //event
        Route::resource('/event', EventController::class, ['except' => 'show' ,'as' => 'admin']);

        //photo
        Route::resource('/photo',PhotoController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        
        //video
        Route::resource('/video', VideoController::class, ['except' => 'show' ,'as' => 'admin']);

        //slider
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'] ,'as' => 'admin']);
        Route::resource('/kelas', KelasController::class, ['except' => ['destroy'] ,'as' => 'admin']);
    });

});
