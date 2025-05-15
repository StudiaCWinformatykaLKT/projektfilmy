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
        $catImageUrl = $this->getCatImageUrl();
        return view('films', compact('films', 'catImageUrl'));
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

        $movies = $response->json();

        if (isset($movies['results'])) {
            $movies = $movies['results'];
        } else {
            $movies = [];
        }

        $films = DB::table('bazfilmow')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('films', compact('movies', 'films', 'catImageUrl'));
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

    private function getCatImageUrl()
    {
        $today = now()->toDateString();
        Log::info('Dzisiaj:', ['today' => $today]);

        // Sprawdź, czy istnieje wpis w tabeli `kotdnia` z dzisiejszą datą
        $catOfTheDay = DB::table('kotdnia')->whereDate('created_at', $today)->first();
        Log::info('Kot dnia:', ['catOfTheDay' => $catOfTheDay]);

        if ($catOfTheDay) {
            Log::info('Zwracany URL z bazy danych:', ['url' => $catOfTheDay->url]);
            return $catOfTheDay->url;
        } else {
            // Pobierz nowy obrazek z API
            $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
            Log::info('Odpowiedź z API:', ['response' => $response]);

            $data = $response->json();
            Log::info('Dane z API:', ['data' => $data]);

            $newUrl = $data['url'];
            Log::info('Nowy URL:', ['newUrl' => $newUrl]);

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