<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;


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
        $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
        $data = $response->json();
        return $data['url'];
    }
}