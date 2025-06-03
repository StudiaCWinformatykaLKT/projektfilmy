<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use App\Models\Bazfilmowwew; // Zaimportuj model Bazfilmowwew, jeśli istnieje, lub użyj DB::table()

class FavUserMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 $users = User::pluck('id')->all();
        $movies = DB::table('bazfilmowwew')->pluck('id')->all();

        // --- POCZĄTEK DEBUGOWANIA ---
        $this->command->info('--- FavUserMovieSeeder Debug ---');
        $this->command->info('Liczba znalezionych użytkowników: ' . count($users));
        if (!empty($users)) {
            $this->command->info('ID użytkowników: ' . implode(', ', $users));
        }
        $this->command->info('Liczba znalezionych filmów: ' . count($movies));
        if (!empty($movies)) {
            $this->command->info('ID filmów: ' . implode(', ', $movies));
        }
        // --- KONIEC DEBUGOWANIA ---

        if (empty($users) || empty($movies)) {
            $this->command->info('Brak użytkowników lub filmów w bazie danych do utworzenia powiązań ulubionych.');
            return;
        }

        $preferences = [];
        $numberOfPreferences = min(count($users) * count($movies), 50); // Utwórz do 50 preferencji lub mniej, jeśli nie ma wystarczającej liczby kombinacji

        $usedCombinations = [];

        for ($i = 0; $i < $numberOfPreferences; $i++) {
            do {
                $userId = $users[array_rand($users)];
                $movieId = $movies[array_rand($movies)];
            } while (isset($usedCombinations[$userId . '-' . $movieId])); // Zapewnij unikalność kombinacji user_id i movie_id

            $usedCombinations[$userId . '-' . $movieId] = true;

            $preferences[] = [
                'user_id' => $userId,
                'movie_id' => $movieId,
                'rating' => rand(0, 1) ? rand(1, 5) : null, // Losowa ocena 1-5 lub null
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('fav_user_movie')->insert($preferences);
        $this->command->info('Planowana liczba preferencji do utworzenia: ' . $numberOfPreferences);

        $usedCombinations = [];
    }
}