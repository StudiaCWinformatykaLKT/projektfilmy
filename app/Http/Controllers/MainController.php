<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Bazfilmowwew;

class MainController extends Controller
{
    // Wyświetlanie kotów dnia
    public function cat()
    {
        $cats = DB::table('kotdnia')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('cat', compact('cats', 'catImageUrl'));
    }

public function films()
{
    // Pobieranie filmów z tabeli bazfilmow i mapowanie do obiektów
    $movies = DB::table('bazfilmow')->get()->map(function ($film) {
        return (object)[
            'id' => $film->id ?? null,
            'title' => $film->title ?? 'Brak tytułu',
            'release_year' => isset($film->release_date) && $film->release_date ? substr($film->release_date, 0, 4) : 'brak danych',
            'genre_ids' => $film->genre_ids ?? '',
            'vote_average' => $film->vote_average ?? '',
            'vote_count' => $film->vote_count ?? '',
            'original_language' => $film->original_language ?? '',
            'overview' => $film->overview ?? '',
            'poster_path' => $film->poster_path ?? '',
            'source' => 'local',
        ];
    });

    // Pobieranie filmów z tabeli bazfilmowwew jako kolekcję obiektów
    $moviesWew = DB::table('bazfilmowwew')->get()->map(function ($movie) {
        return (object)[
            'id' => $movie->id ?? null,
            'title' => $movie->title ?? 'Brak tytułu',
            'release_year' => isset($movie->release_date) && $movie->release_date ? substr($movie->release_date, 0, 4) : 'brak danych',
            'genre_ids' => $movie->genre_ids ?? '',
            'vote_average' => $movie->vote_average ?? '',
            'vote_count' => $movie->vote_count ?? '',
            'original_language' => $movie->original_language ?? '',
            'overview' => $movie->overview ?? '',
            'poster_path' => $movie->poster_path ?? '',
            'source' => 'local',
            'release_date' => $movie->release_date ?? '',
        ];
    });

    // Logowanie danych do debugowania (można usunąć w produkcji)
    //Log::debug('Filmy z bazfilmow:', ['count' => $movies->count()]);
    //Log::debug('Filmy z bazfilmowwew:', ['count' => $moviesWew->count()]);

    $catImageUrl = $this->getCatImageUrl();
    
    return view('films', [
        'movies' => $movies,
        'moviesWew' => $moviesWew,
        'catImageUrl' => $catImageUrl
    ]);
}

    // Wyświetlanie użytkowników
    public function user()
    {
        $users = DB::table('users')->get();
        $catImageUrl = $this->getCatImageUrl();
        $favUserMovies = DB::table('fav_user_movie')
            ->join('users', 'fav_user_movie.user_id', '=', 'users.id')
            ->join('bazfilmowwew', 'fav_user_movie.movie_id', '=', 'bazfilmowwew.id')
            ->select(
                'fav_user_movie.id as fav_id',
                'users.name as user_name',
                'bazfilmowwew.title as movie_title',
                'fav_user_movie.rating',
                'fav_user_movie.created_at as fav_created_at'
            )
            ->orderBy('fav_user_movie.created_at', 'desc') // Opcjonalnie: sortuj wg daty dodania
            ->get();

        return view('user', compact('users', "catImageUrl", 'favUserMovies'));
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

        //Log::info('Odpowiedź z TMDB:', ['response' => $response->json()]);

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
    Log::info('Dostęp do danych testowy:', [
    'database' => DB::connection()->getDatabaseName(),
    'tables' => DB::select('SHOW TABLES'),
    'bazfilmowwew' => DB::table('bazfilmowwew')->get(),
]);
$moviesWew = DB::table('bazfilmowwew')->get()->map(function ($movie) {
    return (object)[
        'id' => $movie->id ?? null,
        'title' => $movie->title ?? 'Brak tytułu',
        'release_year' => isset($movie->release_date) && $movie->release_date ? substr($movie->release_date, 0, 4) : 'brak danych',
        'genre_ids' => $movie->genre_ids ?? '',
        'vote_average' => $movie->vote_average ?? '',
        'vote_count' => $movie->vote_count ?? '',
        'original_language' => $movie->original_language ?? '',
        'overview' => $movie->overview ?? '',
        'poster_path' => $movie->poster_path ?? '',
        'source' => 'local',
        'release_date' => $movie->release_date ?? '',
    ];
});
return view('films', compact('movies', 'catImageUrl', 'moviesWew'));
    }


public function getCatImage()
{
    $catImageUrl = $this->getCatImageUrl();
    $randomMovie = Bazfilmowwew::inRandomOrder()->first();
    $localMoviesCount = Bazfilmowwew::count();
    return view('index', [
        'catImageUrl' => $catImageUrl,
        'randomMovie' => $randomMovie,
        'localMoviesCount' => $localMoviesCount,          
    ]);
}
    public function getCatImageUrl()
    {
        $today = now()->toDateString();
        $catOfTheDay = DB::table('kotdnia')->whereDate('created_at', $today)->first();

        if ($catOfTheDay) {
            return $catOfTheDay->url;
        } else {
            $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
            $data = $response->json();
            $newUrl = $data['url'];
            DB::table('kotdnia')->insert([
                'created_at' => $today,
                'url' => $newUrl,
            ]);
            Log::info('Nowy wpis dodany do bazy danych.');

            return $newUrl;
        }
    }
}
