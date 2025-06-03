<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'], // Warunek wyszukiwania
            ['name' => 'Test User',        
            'password' => bcrypt('password'), 
        ]); 
        // Dodaj kilku dodatkowych użytkowników
        User::factory()->count(3)->create();

         // Przykładowe dane dla tabeli gatunek
         DB::table('gatunek')->insert([
            ['rodzaj' => 'Komedia'],
            ['rodzaj' => 'Dramat'],
            ['rodzaj' => 'Akcja'],
        ]);


DB::table('bazfilmowwew')->insert([
    [
        'adult' => false,
        'backdrop_path' => '/8MksSPtPvqcSDruLdpibPmTP7LY.jpg',
        'belongs_to_collection' => '{"id":528,"name":"The Terminator Collection","poster_path":"\/kpZxdNsAV7qTdTLwKM5NLqa7GEo.jpg","backdrop_path":"\/jz9usvWv5DrQGtjauEU4KSzgb8M.jpg"}',
        'budget' => 102000000,
        'genres' => '[{"id":28,"name":"Action"},{"id":53,"name":"Thriller"},{"id":878,"name":"Science Fiction"}]',
        'homepage' => 'https://www.lionsgate.com/movies/terminator-2-judgment-day',
        'tmdb_id' => 280,
        'imdb_id' => 'tt0103064',
        'origin_country' => '["US"]',
        'original_language' => 'en',
        'original_title' => 'Terminator 2: Judgment Day',
        'overview' => 'Set ten years after the events of the original, James Cameron’s classic sci-fi action flick tells the story of a second attempt to get rid of rebellion leader John Connor, this time targeting the boy himself. However, the rebellion has sent a reprogrammed terminator to protect Connor.',
        'popularity' => 13.1691,
        'poster_path' => '/5M0j0B18abtBI5gi2RhfjjurTqb.jpg',
        'production_companies' => '[{"id":275,"logo_path":"\/2MxNWlN5b3UXt1OfmznsWEQzFwq.png","name":"Carolco Pictures","origin_country":"US"},{"id":1280,"logo_path":null,"name":"Pacific Western","origin_country":"US"},{"id":574,"logo_path":"\/nLNW1TeFUYU0M5U0qmYUzOIwlB6.png","name":"Lightstorm Entertainment","origin_country":"US"},{"id":183,"logo_path":"\/eadyph99FClrWlnE0jPniwOcvvw.png","name":"Le Studio Canal+","origin_country":"FR"}]',
        'production_countries' => '[{"iso_3166_1":"FR","name":"France"},{"iso_3166_1":"US","name":"United States of America"}]',
        'release_date' => '1991-07-03',
        'revenue' => 520000000,
        'runtime' => 137,
        'spoken_languages' => '[{"english_name":"English","iso_639_1":"en","name":"English"},{"english_name":"Spanish","iso_639_1":"es","name":"Espa\u00f1ol"}]',
        'status' => 'Released',
        'tagline' => "It's nothing personal.",
        'title' => 'Terminator 2: Judgment Day',
        'video' => false,
        'vote_average' => 8.125,
        'vote_count' => 13312,
        'genre_ids' => null,
        'created_at' => '2025-05-22 18:59:44',
        'updated_at' => '2025-05-22 18:59:44',
    ],
    [
        'adult' => false,
        'backdrop_path' => null,
        'belongs_to_collection' => null,
        'budget' => 0,
        'genres' => '[{"id":10752,"name":"War"},{"id":10770,"name":"TV Movie"}]',
        'homepage' => '',
        'tmdb_id' => 919755,
        'imdb_id' => 'tt0175039',
        'origin_country' => '["PL"]',
        'original_language' => 'pl',
        'original_title' => 'Piwo',
        'overview' => "The piece is an analysis of a person's attitude in the face of imminent danger, and its action takes place just after World War II. In the train station waiting room, two young men lead a beer discussion, one of whom tells the other an unpleasant incident of his own life.",
        'popularity' => 0.1274,
        'poster_path' => null,
        'production_companies' => '[{"id":52346,"logo_path":null,"name":"Zesp\u00f3\u0142 Filmowy \"Rytm\"","origin_country":"PL"}]',
        'production_countries' => '[{"iso_3166_1":"PL","name":"Poland"}]',
        'release_date' => '1965-11-24',
        'revenue' => 0,
        'runtime' => 24,
        'spoken_languages' => '[{"english_name":"Polish","iso_639_1":"pl","name":"Polski"}]',
        'status' => 'Released',
        'tagline' => '',
        'title' => 'Beer',
        'video' => false,
        'vote_average' => 0,
        'vote_count' => 0,
        'genre_ids' => null,
        'created_at' => '2025-05-29 17:07:40',
        'updated_at' => '2025-05-29 17:07:40',
    ],
    [
        'adult' => false,
        'backdrop_path' => '/tlEFuIlaxRPXIYVHXbOSAMCfWqk.jpg',
        'belongs_to_collection' => null,
        'budget' => 55000000,
        'genres' => '[{"id":35,"name":"Comedy"},{"id":18,"name":"Drama"},{"id":10749,"name":"Romance"}]',
        'homepage' => 'https://www.paramountmovies.com/movies/forrest-gump',
        'tmdb_id' => 13,
        'imdb_id' => 'tt0109830',
        'origin_country' => '["US"]',
        'original_language' => 'en',
        'original_title' => 'Forrest Gump',
        'overview' => "A man with a low IQ has accomplished great things in his life and been present during significant historic events—in each case, far exceeding what anyone imagined he could do. But despite all he has achieved, his one true love eludes him.",
        'popularity' => 27.1554,
        'poster_path' => '/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg',
        'production_companies' => '[{"id":4,"logo_path":"\/gz66EfNoYPqHTYI4q9UEN4CbHRc.png","name":"Paramount Pictures","origin_country":"US"},{"id":21920,"logo_path":null,"name":"The Steve Tisch Company","origin_country":"US"},{"id":412,"logo_path":null,"name":"Wendy Finerman Productions","origin_country":""}]',
        'production_countries' => '[{"iso_3166_1":"US","name":"United States of America"}]',
        'release_date' => '1994-06-23',
        'revenue' => 677387716,
        'runtime' => 142,
        'spoken_languages' => '[{"english_name":"English","iso_639_1":"en","name":"English"}]',
        'status' => 'Released',
        'tagline' => "The world will never be the same once you've seen it through the eyes of Forrest Gump.",
        'title' => 'Forrest Gump',
        'video' => false,
        'vote_average' => 8.468,
        'vote_count' => 28239,
        'genre_ids' => null,
        'created_at' => '2025-05-29 17:08:38',
        'updated_at' => '2025-05-29 17:08:38',
    ],
    [
        'adult' => false,
        'backdrop_path' => '/1uQSh7P3k0oRbRf0vH8GVt4thpP.jpg',
        'belongs_to_collection' => '{"id":10,"name":"Star Wars Collection","poster_path":"\/aSrMJYmQX8kpF26LijkCsYhBMvm.jpg","backdrop_path":"\/zZDkgOmFMVYpGAkR9Tkxw0CRnxX.jpg"}',
        'budget' => 120000000,
        'genres' => '[{"id":12,"name":"Adventure"},{"id":28,"name":"Action"},{"id":878,"name":"Science Fiction"}]',
        'homepage' => '',
        'tmdb_id' => 1894,
        'imdb_id' => 'tt0121765',
        'origin_country' => '["US"]',
        'original_language' => 'en',
        'original_title' => 'Star Wars: Episode II - Attack of the Clones',
        'overview' => "Following an assassination attempt on Senator Padmé Amidala, Jedi Knights Anakin Skywalker and Obi-Wan Kenobi investigate a mysterious plot that could change the galaxy forever.",
        'popularity' => 10.6059,
        'poster_path' => '/oZNPzxqM2s5DyVWab09NTQScDQt.jpg',
        'production_companies' => '[{"id":1,"logo_path":"\/tlVSws0RvvtPBwViUyOFAO0vcQS.png","name":"Lucasfilm Ltd.","origin_country":"US"}]',
        'production_countries' => '[{"iso_3166_1":"US","name":"United States of America"}]',
        'release_date' => '2002-05-15',
        'revenue' => 649398328,
        'runtime' => 142,
        'spoken_languages' => '[{"english_name":"English","iso_639_1":"en","name":"English"}]',
        'status' => 'Released',
        'tagline' => "A Jedi shall not know anger. Nor hatred. Nor love.",
        'title' => 'Star Wars: Episode II - Attack of the Clones',
        'video' => false,
        'vote_average' => 6.578,
        'vote_count' => 13586,
        'genre_ids' => null,
        'created_at' => '2025-05-29 17:08:56',
        'updated_at' => '2025-05-29 17:08:56',
    ],
    [
        'adult' => false,
        'backdrop_path' => '/50P73nEoHAc6LJpGl4l43hey6RD.jpg',
        'belongs_to_collection' => '{"id":373918,"name":"Garfield CGI Collection","poster_path":"\/uN4pZ94CSNYVnJNLr4Bdieh01XO.jpg","backdrop_path":"\/otxv1Y3eSC2teENH138MEErcmUr.jpg"}',
        'budget' => 0,
        'genres' => '[{"id":10751,"name":"Family"},{"id":35,"name":"Comedy"},{"id":12,"name":"Adventure"},{"id":16,"name":"Animation"}]',
        'homepage' => '',
        'tmdb_id' => 19508,
        'imdb_id' => 'tt1389762',
        'origin_country' => '["US"]',
        'original_language' => 'en',
        'original_title' => "Garfield's Pet Force",
        'overview' => "Nothing in the world can make Garfield get involved in anything besides eating, until the muscular super cat Garzooka comes crashing into Cartoon World from the Comic Book universe with terrifying news. Garfield summons up the willpower to join his superhero Garzooka in a fight to save their worlds.",
        'popularity' => 1.0577,
        'poster_path' => '/ylbBsF1WKI0RrxfX89QFqrBPYKu.jpg',
        'production_companies' => '[{"id":15196,"logo_path":null,"name":"Animation Picture Company","origin_country":"US"},{"id":1302,"logo_path":"\/zC3b70ixHh89qJIikLQPEvLqbPM.png","name":"Davis Entertainment","origin_country":"US"},{"id":4569,"logo_path":"\/gpc5vn0dBR4N5MKNGxiUxWD98rD.png","name":"Paws","origin_country":"US"},{"id":3635,"logo_path":"\/e4dCQJpJjwL46i1WuGpTIO3srL6.png","name":"20th Century Fox Home Entertainment","origin_country":"US"},{"id":4439,"logo_path":null,"name":"Digiart Productions","origin_country":"KR"}]',
        'production_countries' => '[{"iso_3166_1":"KR","name":"South Korea"},{"iso_3166_1":"US","name":"United States of America"}]',
        'release_date' => '2009-09-11',
        'revenue' => 11445294,
        'runtime' => 77,
        'spoken_languages' => '[{"english_name":"English","iso_639_1":"en","name":"English"}]',
        'status' => 'Released',
        'tagline' => "Let the Fur Fly!",
        'title' => "Garfield's Pet Force",
        'video' => false,
        'vote_average' => 5.4,
        'vote_count' => 100,
        'genre_ids' => null,
        'created_at' => '2025-05-29 17:09:15',
        'updated_at' => '2025-05-29 17:09:15',
    ],
]);


        DB::table('kotdnia')->insert([
            [
                'created_at' => '2025-03-15',
                'updated_at' => '2025-03-15',
                'url' => 'https://cataas.com/cat?type=medium&position=center&html=true',
            ],
            [
                'created_at' => '2025-03-16',
                'updated_at' => '2025-03-16',
                'url' => 'https://example.com/kot2.jpg',
            ],
        ]);

         $this->call([
            FavUserMovieSeeder::class,
        ]);

    }
}
