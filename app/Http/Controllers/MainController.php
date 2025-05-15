<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    // Wyświetlanie kotów dnia
    public function cat()
    {
        $cats = DB::table('kotdnia')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('cat', compact('cats', 'catImageUrl'));
    }

    // Wyświetlanie filmów
public function films()
{
    $films = DB::table('bazfilmow')->get();
    $movies = collect($films)->map(function ($film) {
        return [
            'id' => $film->id,
            'title' => $film->tytul,
            'rokpremiery' => $film->rok_premiery,
            'source' => 'local',
        ];
    });
    $catImageUrl = $this->getCatImageUrl();
    return view('films', compact('movies', 'catImageUrl'));
    }

    // Wyświetlanie użytkowników
    public function user()
    {
        $users = DB::table('users')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('user', compact('users', 'catImageUrl'));
    }

    // Wyszukiwanie filmów za pomocą API TMDB
    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY');

        $response = Http::get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
        ]);

        // Dodaj to logowanie:
        Log::info('Odpowiedź z TMDB:', ['response' => $response->json()]);

        $movies = $response->json();

        if (isset($movies['results'])) {
        $movies = collect($movies['results'])->map(function ($movie) {
            return [
                'id' => $movie['id'],
                'title' => $movie['title'],
                'release_year' => isset($movie['release_date']) && $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'brak danych',
                'source' => 'api',
            ];
        });
    } else {
        $movies = collect();
    }

    $catImageUrl = $this->getCatImageUrl();
    return view('films', compact('movies', 'catImageUrl'));
    }

    // Wyświetlanie losowego kota w layoucie
    public function getCatImage()
    {
        $catImageUrl = $this->getCatImageUrl();
        return view('layouts.lay', compact('catImageUrl'));
    }

    /**
     * Helper function: Pobiera URL kota dnia z bazy danych lub API.
     */

    public function getCatImageUrl()
    {
        $today = now()->toDateString();
        $catOfTheDay = DB::table('kotdnia')->whereDate('created_at', $today)->first();

        if ($catOfTheDay) {
            return $catOfTheDay->url;
        } else {
            // Pobierz nowy obrazek z API
            $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
            $data = $response->json();
            $newUrl = $data['url'];
            // Dodaj nowy wpis do tabeli `kotdnia`
            DB::table('kotdnia')->insert([
                'created_at' => $today,
                'url' => $newUrl,
            ]);
            Log::info('Nowy wpis dodany do bazy danych.');

            return $newUrl;
        }
    }
}