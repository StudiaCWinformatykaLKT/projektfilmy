<?php
use App\Http\Controllers\MainController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

// WŁASNE STRONY
Route::get('/cat', [MainController::class, 'cat'])->name('cat');
Route::get('/films', [MainController::class, 'films'])->name('films');
Route::get('/user', [MainController::class, 'user'])->name('user');
Route::get('/', [MainController::class, 'getCatImage'])->name('cat.image');
Route::get('/search', [MainController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');
Route::post('/movies/add-to-local', [MovieController::class, 'addToLocal'])->name('movies.addToLocal');

// PROFIL I AUTORYZACJA (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dodaj to na końcu, żeby załadować trasy logowania, rejestracji itd.
require __DIR__.'/auth.php';
