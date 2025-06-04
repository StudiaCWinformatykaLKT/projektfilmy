<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MovieController;




class AuthController extends Controller
{
       public function showRegistrationForm()
    {
        return view('regview');
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Rejestracja zakończona sukcesem! Zostałeś zalogowany.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Zalogowano pomyślnie!');
        }

        return back()->withErrors([
            'email' => 'Podane dane logowania są nieprawidłowe.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Wylogowano pomyślnie!');
    }
/**
     * Display the authenticated user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user(); // Pobierz zalogowanego użytkownika

        // Pobierz ulubione filmy i oceny użytkownika
        $userFavorites = DB::table('fav_user_movie')
            ->join('bazfilmowwew', 'fav_user_movie.movie_id', '=', 'bazfilmowwew.id')
            ->where('fav_user_movie.user_id', $user->id)
            ->select('bazfilmowwew.title as movie_title', 'fav_user_movie.rating', 'fav_user_movie.created_at as favorite_created_at', 'fav_user_movie.movie_id')
            ->orderBy('fav_user_movie.created_at', 'desc')
            ->get();

        $catImageUrl = app(MainController::class)->getCatImageUrl();

        return view('profile', compact('user', 'userFavorites', 'catImageUrl'));
    }
}
