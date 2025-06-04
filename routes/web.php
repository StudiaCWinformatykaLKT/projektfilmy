<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegController;





Route::get('/cat', [MainController::class, 'cat'])->name('cat');
Route::get('/films', [MainController::class, 'films'])->name('films');
Route::get('/user', [MainController::class, 'user'])->name('user');
Route::get('/', [MainController::class, 'getCatImage'])->name('cat.image');

Route::get('/search', [MainController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::post('/movies/add-to-local', [\App\Http\Controllers\MovieController::class, 'addToLocal'])->name('movies.addToLocal');

// Trasy obsługiwane wcześniej przez RegController, teraz przez AuthController lub dedykowane
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register'); // Zakładając, że AuthController będzie miał metodę do wyświetlania formularza
// Route::post('/register', [RegController::class, 'register'])->name('register.post'); // Zastąpione przez AuthController
// Route::post('/login', [RegController::class, 'login'])->name('login.post'); // Zastąpione przez AuthController
Route::get('/login', function () {return view('login');})->name('login');
Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('forgot-password.post'); // Przenieś logikę resetowania hasła do AuthController
Route::get('/forgot-password', function() {return view('forgot-password');})->name('forgot-password');
// Route::post('/logout', function() {session()->forget('user');return redirect('/')->with('success', 'Wylogowano pomyślnie!'); })->name('logout'); // Zastąpione przez AuthController GET /logout

Route::get('/doc/dokumentacja.pdf', function () {
    $path = public_path('doc/dokumentacja.pdf');
    if (file_exists($path)) {
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }
    abort(404);
})->name('dokumentacja.pdf');

// Główne trasy autentykacji
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profil', [App\Http\Controllers\AuthController::class, 'show'])->name('user.profile')->middleware('auth');

// Trasy do obsługi ulubionych i ocen
Route::post('/movies/rate-favorite', [MovieController::class, 'rateOrFavoriteMovie'])->name('movies.rateOrFavorite')->middleware('auth');
Route::post('/movies/remove-favorite', [MovieController::class, 'removeFromFavorites'])->name('movies.removeFromFavorites')->middleware('auth');
