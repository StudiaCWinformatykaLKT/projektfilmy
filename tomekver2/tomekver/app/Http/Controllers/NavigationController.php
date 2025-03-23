<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function cat()
    {
        $cats = DB::table('kotdnia')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('cat', compact('cats', 'catImageUrl'));
    }

    public function films()
    {
        $films = DB::table('bazfilmow')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('films', compact('films', 'catImageUrl'));
    }

    public function user()
    {
        $users = DB::table('users')->get();
        $catImageUrl = $this->getCatImageUrl();
        return view('user', compact('users', 'catImageUrl'));
    }

    /**
     * Fetches a random cat image URL from the Cataas API and returns it to the view.
     */
    public function getCatImage()
    {
        $catImageUrl = $this->getCatImageUrl();
        return view('layouts.lay', compact('catImageUrl'));
    }

    /**
     * Helper function to fetch a random cat image URL from the Cataas API.
     */
    private function getCatImageUrl()
    {
        $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
        $data = $response->json();
        return $data['url'];
    }
}