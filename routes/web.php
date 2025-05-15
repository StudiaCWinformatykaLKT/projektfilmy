<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});

Route::get('/cat', [MainController::class, 'cat'])->name('cat');
Route::get('/films', [MainController::class, 'films'])->name('films');
Route::get('/user', [MainController::class, 'user'])->name('user');
Route::get('/', [MainController::class, 'getCatImage'])->name('cat.image');

Route::get('/search', [MainController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
