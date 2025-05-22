<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class RegController extends Controller
{
    public function showForm()
    {
        return view('regview');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Session::put('user', $user);

        return redirect('/')->with('success', 'Rejestracja zakończona sukcesem!');
    }


public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        session(['user' => $user]);
        return redirect('/')->with('success', 'Zalogowano pomyślnie!');
    }
    return back()->withErrors(['email' => 'Nieprawidłowy email lub hasło']);
}
}
