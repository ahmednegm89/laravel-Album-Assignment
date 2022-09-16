<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ImageController;
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

Route::get('/', function () {
    return view('album.index');
});


// albums routes

Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::post('/albums/store', [AlbumController::class, 'store'])->name('album.store');
Route::get('/albums/show/{id}', [AlbumController::class, 'show'])->name('album.show');
Route::post('/albums/update/{id}', [AlbumController::class, 'update'])->name('album.update');
Route::get('/albums/delete/{id}', [AlbumController::class, 'delete'])->name('album.delete');
Route::get('/albums/move', [AlbumController::class, 'move'])->name('album.move');

// images routes 
Route::post('/image/store', [ImageController::class, 'store'])->name('image.store');
Route::get('/image/delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
