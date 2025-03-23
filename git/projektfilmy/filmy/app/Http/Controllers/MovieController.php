<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function show($id)
    {
        $apiKey = env('TMDB_API_KEY');

        $url = 'https://api.themoviedb.org/3/movie/' . $id . '?api_key=' . $apiKey;

        try {
            $response = Http::get($url);

            $movieData = $response->json();

            if ($movieData) {

                $imageBaseUrl = 'https://image.tmdb.org/t/p/w500';

                return view('movie', ['movieData' => $movieData, 'imageBaseUrl' => $imageBaseUrl]);
            } else {
                abort(404, 'Movie not found');
            }
        } catch (\Exception $e) {
            abort(500, 'Error fetching movie data: ' . $e->getMessage());
        }
    }
}
