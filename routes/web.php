<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TempImageController;
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

Route::get('/', [AlbumController::class, 'create'])->name('dashboard');
Route::get('album/create', [AlbumController::class, 'create'])->name('albumcreate');
Route::group(['prefix' => 'album', 'as' => 'album.'], function () {
    Route::get('/', [AlbumController::class, 'index'])->name('index');
    Route::get('/albums_except', [AlbumController::class, 'albumsExcept'])->name('albums_except');
    Route::get('/create', [AlbumController::class, 'create'])->name('create');
    Route::get('/{album}', [AlbumController::class, 'show'])->name('show');
    Route::get('/add/pic/{album}', [AlbumController::class, 'addPic'])->name('add_pic');
    Route::post('/store/pic/{album}', [AlbumController::class, 'storePic'])->name('store_photos');
    Route::post('/move_photos/{album}', [AlbumController::class, 'movePhotos'])->name('move_photos');
    Route::post('store', [AlbumController::class, 'store'])->name('store');
    Route::get('edit/{album}', [AlbumController::class, 'edit'])->name('edit');
    Route::put('update/{album}', [AlbumController::class, 'update'])->name('update');
    Route::delete('/{album}', [AlbumController::class, 'destroy'])->name('delete');
});


Route::post('upload_temp', [TempImageController::class, 'store'])->name('store_temp');
Route::get('delete_temp', [TempImageController::class, 'destroy'])->name('delete_temp');
