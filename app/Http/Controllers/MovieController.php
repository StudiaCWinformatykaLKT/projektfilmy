<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
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

        // Wyszukiwanie lokalne
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
    
});
dd($moviesWew);
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
    if ($source === 'local') {
        $movie = DB::table('bazfilmowwew')->where('id', $id)->first(); 
        $movieExistsInLocalDb = true;
    } else {
        $apiKey = env('TMDB_API_KEY');
        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
            'api_key' => $apiKey,
        ]);
        $movie = $response->json();
        $movieExistsInLocalDb = false;
        if (isset($movie['id'])) {
            $movieExistsInLocalDb = DB::table('bazfilmowwew')->where('tmdb_id', $movie['id'])->exists();
        }
    }
    $catImageUrl = app(\App\Http\Controllers\MainController::class)->getCatImageUrl();
    $moviesWew = DB::table('bazfilmowwew')->get();
    return view('movie_show', compact('movie', 'source', 'moviesWew', 'catImageUrl', 'movieExistsInLocalDb'));
}

    private function getCatImageUrl()
{
    $today = now()->toDateString();
    $catOfTheDay = DB::table('kotdnia')->whereDate('created', $today)->first();
    if ($catOfTheDay) {
        return $catOfTheDay->url;
    } else {
        $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
        $data = $response->json();
        $newUrl = $data['url'];


        DB::table('kotdnia')->insert([
            'created' => $today,
            'url' => $newUrl,
        ]);
        Log::info('Nowy wpis dodany do bazy danych.');

        return $newUrl;
    }
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
DB::table('bazfilmowwew')->insert([
    'adult' => $data['adult'] ?? false,
    'backdrop_path' => $data['backdrop_path'] ?? null,
    'belongs_to_collection' => isset($data['belongs_to_collection']) ? json_encode($data['belongs_to_collection']) : null,
    'budget' => $data['budget'] ?? null,
    'genres' => isset($data['genres']) ? json_encode($data['genres']) : null,
    'homepage' => $data['homepage'] ?? null,
    'tmdb_id' => $data['id'] ?? null, // <-- to jest ID z TMDB!
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
    'created_at' => now(),
    'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Film został dodany do bazy!');
}
}
