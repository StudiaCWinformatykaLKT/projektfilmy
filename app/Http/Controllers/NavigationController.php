<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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

    public function getCatImage()
    {
        $catImageUrl = $this->getCatImageUrl();
        return view('layouts.lay', compact('catImageUrl'));
    }
    private function getCatImageUrl()
    {
        $response = Http::get('https://cataas.com/cat?type=medium&position=center&json=true');
        $data = $response->json();
        return $data['url'];
    }
}