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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
         // Przykładowe dane dla tabeli gatunek
         DB::table('gatunek')->insert([
            ['rodzaj' => 'Komedia'],
            ['rodzaj' => 'Dramat'],
            ['rodzaj' => 'Akcja'],
        ]);

        DB::table('bazfilmowwew')->insert([
            [
                'adult' => false,
                'backdrop_path' => '/path/to/backdrop.jpg',
                'original_language' => 'en',
                'original_title' => 'Original Title 1',
                'overview' => 'Overview of film 1',
                'popularity' => 10.0,
                'poster_path' => '/path/to/poster1.jpg',
                'release_date' => '2025-03-15',
                'title' => 'Film 1',
                'video' => false,
                'vote_average' => 8.5,
                'vote_count' => 100,
                'genre_ids' => json_encode([1, 2]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'adult' => false,
                'backdrop_path' => '/path/to/backdrop2.jpg',
                'original_language' => 'en',
                'original_title' => 'Original Title 2',
                'overview' => 'Overview of film 2',
                'popularity' => 20.0,
                'poster_path' => '/path/to/poster2.jpg',
                'release_date' => '2025-03-16',
                'title' => 'Film 2',
                'video' => false,
                'vote_average' => 7.5,
                'vote_count' => 200,
                'genre_ids' => json_encode([2, 3]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Przykładowe dane dla tabeli kotdnia
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

    }
}
