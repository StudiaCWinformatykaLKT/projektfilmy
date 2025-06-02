<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegController;





Route::get('/cat', [MainController::class, 'cat'])->name('cat');
Route::get('/films', [MainController::class, 'films'])->name('films');
Route::get('/user', [MainController::class, 'user'])->name('user');
Route::get('/', [MainController::class, 'getCatImage'])->name('cat.image');

Route::get('/search', [MainController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::post('/movies/add-to-local', [\App\Http\Controllers\MovieController::class, 'addToLocal'])->name('movies.addToLocal');

Route::get('/register', [RegController::class, 'showForm'])->name('register');
Route::post('/register', [RegController::class, 'register'])->name('register.post');
Route::post('/login', [RegController::class, 'login'])->name('login.post');
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/forgot-password', [RegController::class, 'forgot-password'])->name('forgot-password.post');
Route::get('/forgot-password', function() {return view('forgot-password');})->name('forgot-password');
Route::post('/logout', function() {session()->forget('user');return redirect('/')->with('success', 'Wylogowano pomyślnie!'); })->name('logout');

Route::get('/doc/dokumentacja.pdf', function () {
    $path = public_path('doc/dokumentacja.pdf');
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }
    abort(404);
})->name('dokumentacja.pdf');
