<?php


use App\Http\Controllers\NavigationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


Route::get('/', function () {
    return view('index');
});

Route::get('/cat', [NavigationController::class, 'cat'])->name('cat');
Route::get('/films', [NavigationController::class, 'films'])->name('films');
Route::get('/user', [NavigationController::class, 'user'])->name('user');
Route::get('/', [NavigationController::class, 'getCatImage'])->name('cat.image');

Route::get('/search', [MovieController::class, 'search'])->name('movies.search');