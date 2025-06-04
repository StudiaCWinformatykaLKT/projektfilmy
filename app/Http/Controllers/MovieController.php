<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class MovieController extends Controller
{

public function search(Request $request)
{
    try {
        $query = $request->input('query');
        if (empty($query)) {
            return back()->with('error', 'Puste zapytanie');
        }
        $localMovies = collect();
        try {
            $localMovies = DB::table('bazfilmow')
                ->where('tytul', 'like', '%' . $query . '%')
                ->get(['id', 'tytul as title', 'rok_premiery as release_year']);
        } catch (\Exception $e) {
            Log::error('Błąd lokalnego wyszukiwania', ['error' => $e->getMessage()]);
        }

        $movies = $localMovies->isNotEmpty() 
            ? $localMovies->map(fn($m) => (object)[
                'id' => $m->id,
                'title' => $m->title,
                'release_year' => $m->release_year,
            ]) 
            : $this->searchTmdb($query);

$moviesWew = DB::table('bazfilmowwew')->get()->map(function ($movie) {
    $movie->genre_ids = json_decode($movie->genre_ids, true) ?? [];
    return $movie;
    
}); // Usunięto dd()
        return view('films', [
            'movies' => $movies,
            'moviesWew' => $moviesWew,
            'catImageUrl' => app(MainController::class)->getCatImageUrl(),
            'searchQuery' => $query
        ]);

    } catch (\Exception $e) {
        Log::critical('Błąd w search', ['error' => $e]);
        abort(500, 'Wystąpił błąd podczas wyszukiwania');
    }
}

private function searchTmdb($query)
{
    $apiKey = env('TMDB_API_KEY');
    if (!$apiKey) {
        Log::error('Brak klucza TMDB');
        return collect();
    }

    $response = Http::retry(3, 100)
        ->get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => $apiKey,
        ]);
    return $response->successful()
        ? collect($response->json('results'))->map(fn($m) => (object)[
            'id' => $m['id'] ?? null,
            'title' => $m['title'] ?? '',
            'release_year' => isset($m['release_date']) ? substr($m['release_date'], 0, 4) : null,
        ])
        : collect();
}



public function show(Request $request, $id)
{
    $source = $request->query('source', 'local');
    $movie = null;
    $movieExistsInLocalDb = false;
    $localMovieId = null; // Inicjalizujemy ID filmu w lokalnej bazie

    $currentUserFavorite = null; // Status ulubionych/oceny bieżącego użytkownika
    $movie_id_for_actions = null; // ID filmu z tabeli bazfilmowwew do użycia w akcjach

    if ($source === 'local') {
        // $id to ID filmu w tabeli bazfilmowwew
        $movie = DB::table('bazfilmowwew')->where('id', $id)->first();
        if ($movie) {
            $movieExistsInLocalDb = true; // Film jest z lokalnej bazy
            $localMovieId = $movie->id;   // ID lokalne to $id przekazane w URL
            $movie_id_for_actions = $movie->id; // Ustawiamy ID dla akcji użytkownika
        }
    } else { // $source === 'api'
        // $id to TMDB ID
        $apiKey = env('TMDB_API_KEY');
        if (empty($apiKey)) {
            Log::error('Klucz TMDB API nie jest ustawiony.');
            abort(500, 'Błąd konfiguracji serwera.');
        }

        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
            'api_key' => $apiKey,
            'language' => 'pl-PL', // Pobieranie danych po polsku
        ]);

        if ($response->successful()) {
            $movie = $response->json(); // Dane filmu z API jako tablica

            // Sprawdzamy, czy API zwróciło poprawne dane filmu z 'id'
            if (!empty($movie) && isset($movie['id'])) {
                // Sprawdzamy, czy film z TMDB (identyfikowany przez $movie['id']) istnieje w lokalnej bazie
                $localMovieRecord = DB::table('bazfilmowwew')->where('tmdb_id', $movie['id'])->first();
                if ($localMovieRecord) {
                    $movieExistsInLocalDb = true;
                    $localMovieId = $localMovieRecord->id; // ID filmu w tabeli bazfilmowwew
                    $movie_id_for_actions = $localMovieRecord->id; // Ustawiamy ID dla akcji użytkownika
                }
            } else {
                // API zwróciło sukces, ale brak danych filmu lub są niekompletne
                $movie = null;
                Log::warning('TMDB API zwróciło sukces, ale brak poprawnych danych filmu.', ['tmdb_id' => $id, 'response' => $movie]);
            }
        } else {
            Log::error('Błąd podczas pobierania filmu z TMDB API.', [
                'tmdb_id' => $id,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // $movie pozostaje null
        }
    }

    if (!$movie) {
        abort(404, 'Film nie został znaleziony.');
    }

    // Jeśli mamy ID filmu dla akcji i użytkownik jest zalogowany, pobierz jego status ulubionych/oceny
    if (Auth::check() && $movie_id_for_actions) {
        $currentUserFavorite = DB::table('fav_user_movie')
            ->where('user_id', Auth::id())
            ->where('movie_id', $movie_id_for_actions)
            ->first(); // Zawiera 'rating', jeśli istnieje
    }

    // Pobierz liczbę ocen i średnią ocenę dla tego filmu z tabeli fav_user_movie
    $ratingStats = null;
    if ($movie_id_for_actions) {
        $ratingStats = DB::table('fav_user_movie')
            ->where('movie_id', $movie_id_for_actions)
            ->select(DB::raw('COUNT(rating) as rating_count'), DB::raw('AVG(rating) as average_rating'))
            ->first();
    }

    $catImageUrl = app(\App\Http\Controllers\MainController::class)->getCatImageUrl();
    return view('movie_show', compact(
        'movie',
        'source',
        'ratingStats',          // Nowe: Statystyki ocen
        'movie_id_for_actions', // ID filmu z bazfilmowwew do akcji
        'catImageUrl',
        'movieExistsInLocalDb',
        'localMovieId',
        'movie_id_for_actions', // Nowe: ID filmu z bazfilmowwew do akcji
        'currentUserFavorite'   // Nowe: Aktualny status ulubionych/oceny użytkownika
    ));
}

public function addToLocal(Request $request)
{
    $json = $request->input('movie');

    $json = html_entity_decode($json);

    $data = json_decode($json, true);

Log::info('Dane do zapisu:', $data);

    if (!$data) {
        return back()->with('error', 'Brak danych do zapisania!');
    }
    $movieData = [
        'adult' => $data['adult'] ?? false,
        'backdrop_path' => $data['backdrop_path'] ?? null,
        'belongs_to_collection' => isset($data['belongs_to_collection']) ? json_encode($data['belongs_to_collection']) : null,
        'budget' => $data['budget'] ?? null,
        'genres' => isset($data['genres']) ? json_encode($data['genres']) : null,
        'homepage' => $data['homepage'] ?? null,
        'imdb_id' => $data['imdb_id'] ?? null,
        'origin_country' => isset($data['origin_country']) ? json_encode($data['origin_country']) : null,
        'original_language' => $data['original_language'] ?? null,
        'original_title' => $data['original_title'] ?? null,
        'overview' => $data['overview'] ?? null,
        'popularity' => $data['popularity'] ?? null,
        'poster_path' => $data['poster_path'] ?? null,
        'production_companies' => isset($data['production_companies']) ? json_encode($data['production_companies']) : null,
        'production_countries' => isset($data['production_countries']) ? json_encode($data['production_countries']) : null,
        'release_date' => $data['release_date'] ?? null,
        'revenue' => $data['revenue'] ?? null,
        'runtime' => $data['runtime'] ?? null,
        'spoken_languages' => isset($data['spoken_languages']) ? json_encode($data['spoken_languages']) : null,
        'status' => $data['status'] ?? null,
        'tagline' => $data['tagline'] ?? null,
        'title' => $data['title'] ?? null,
        'video' => $data['video'] ?? false,
        'vote_average' => $data['vote_average'] ?? null,
        'vote_count' => $data['vote_count'] ?? null,
        'genre_ids' => isset($data['genre_ids']) ? json_encode($data['genre_ids']) : null,
        'updated_at' => now(),
    ];

   
    DB::table('bazfilmowwew')->updateOrInsert(
        ['tmdb_id' => $data['id'] ?? null],
        array_merge($movieData, ['created_at' => now()])
    );

    return redirect()->back()->with('success', 'Film został dodany/zaktualizowany w bazie!');
}

public function rateOrFavoriteMovie(Request $request)
{
    $request->validate([
        'movie_id' => 'required|integer|exists:bazfilmowwew,id',
        'rating' => 'nullable|integer|min:1|max:5', // Ocena jest opcjonalna
    ]);

    $userId = Auth::id();
    if (!$userId) {
        return back()->with('error', 'Musisz być zalogowany.');
    }

    $movieId = $request->input('movie_id');
    $ratingValue = $request->input('rating'); // Przychodzi z przycisków oceny (może być "" dla usunięcia oceny)

    $existingEntry = DB::table('fav_user_movie')
        ->where('user_id', $userId)
        ->where('movie_id', $movieId)
        ->first();

    $dataToUpdateOrInsert = [
        'user_id' => $userId,
        'movie_id' => $movieId,
        'updated_at' => now(),
    ];

    $message = '';

    if ($request->has('rating_action')) { // Jeśli kliknięto przycisk oceny
        $dataToUpdateOrInsert['rating'] = ($ratingValue === "" || is_null($ratingValue)) ? null : (int)$ratingValue;
        if ($existingEntry) {
            $message = ($ratingValue === "" || is_null($ratingValue)) ? 'Ocena usunięta.' : 'Ocena zaktualizowana.';
        } else {
            $message = ($ratingValue === "" || is_null($ratingValue)) ? 'Film dodany do ulubionych (bez oceny).' : 'Film dodany do ulubionych i oceniony.';
        }
    } else { // Kliknięto przycisk "Dodaj do Ulubionych"
        if ($existingEntry) {
            $dataToUpdateOrInsert['rating'] = $existingEntry->rating; // Zachowaj istniejącą ocenę
            $message = 'Film jest już w ulubionych.';
        } else {
            $dataToUpdateOrInsert['rating'] = null; // Nowy ulubiony, bez określonej oceny przez tę akcję
            $message = 'Film dodany do ulubionych.';
        }
    }

    DB::table('fav_user_movie')->updateOrInsert(
        ['user_id' => $userId, 'movie_id' => $movieId], // Warunki wyszukiwania
        array_merge($dataToUpdateOrInsert, $existingEntry ? [] : ['created_at' => now()]) // Dane do wstawienia/aktualizacji
    );

    return back()->with('success', $message);
}

public function removeFromFavorites(Request $request)
{
    $request->validate([
        'movie_id' => 'required|integer|exists:bazfilmowwew,id',
    ]);
    $userId = Auth::id();
    if (!$userId) { return back()->with('error', 'Musisz być zalogowany.'); }
    $movieId = $request->input('movie_id');

    $deleted = DB::table('fav_user_movie')
        ->where('user_id', $userId)
        ->where('movie_id', $movieId)
        ->delete();

    if ($deleted) {
        return back()->with('success', 'Film usunięto z ulubionych.');
    }
    return back()->with('info', 'Film nie był w ulubionych.');
}
}
