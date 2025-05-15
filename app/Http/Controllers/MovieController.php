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
    $query = $request->input('query');

$localMovies = DB::table('bazfilmow')
    ->where('tytul', 'like', '%' . $query . '%')
    ->get(['id', 'tytul', 'rok_premiery']);

$movies = collect();

if ($localMovies->isNotEmpty()) {
    $movies = $localMovies->map(function ($movie) {
        return [
            'id' => $movie->id,
            'title' => $movie->tytul,
            'release_year' => $movie->rok_premiery,
            'source' => 'local', // <- dodaj ten klucz
        ];
    });
} else {
    $apiKey = env('TMDB_API_KEY');
    $response = Http::get("https://api.themoviedb.org/3/search/movie", [
        'api_key' => $apiKey,
        'query' => $query,
    ]);
    $apiMovies = $response->json('results') ?? [];
    $movies = collect($apiMovies)->map(function ($movie) {
        return [
            'id' => $movie['id'],
            'title' => $movie['title'],
            'release_year' => isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'brak danych',
            'source' => 'api', // <- dodaj ten klucz
        ];
    });
}

    return view('films', compact('movies'));
}

public function show(Request $request, $id)
{
    $source = $request->query('source', 'local');
    if ($source === 'local') {
        $movie = DB::table('bazfilmow')->where('id', $id)->first();
    } else {
        $apiKey = env('TMDB_API_KEY');
        $response = Http::get("https://api.themoviedb.org/3/movie/{$id}", [
            'api_key' => $apiKey,
        ]);
        $movie = $response->json();
    }
    $catImageUrl = app(\App\Http\Controllers\MainController::class)->getCatImageUrl();
    return view('movie_show', compact('movie', 'source', 'catImageUrl'));
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
}