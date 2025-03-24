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
        return view('films', compact('movies','films', 'catImageUrl'));
    }

    private function getCatImageUrl()
{
    $today = now()->toDateString();
    Log::info('Dzisiaj:', ['today' => $today]);

    $catOfTheDay = DB::table('kotdnia')->whereDate('created', $today)->first();
    Log::info('Kot dnia:', ['catOfTheDay' => $catOfTheDay]);

    if ($catOfTheDay) {
        Log::info('Zwracany URL z bazy danych:', ['url' => $catOfTheDay->url]);
        return $catOfTheDay->url;
    } else {
        $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
        Log::info('Odpowiedź z API:', ['response' => $response]);

        $data = $response->json();
        Log::info('Dane z API:', ['data' => $data]);

        $newUrl = $data['url'];
        Log::info('Nowy URL:', ['newUrl' => $newUrl]);

        DB::table('kotdnia')->insert([
            'created' => $today,
            'url' => $newUrl,
        ]);
        Log::info('Nowy wpis dodany do bazy danych.');

        return $newUrl;
    }
}
}