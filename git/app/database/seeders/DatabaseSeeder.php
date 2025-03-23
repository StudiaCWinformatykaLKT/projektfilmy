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

        // Przykładowe dane dla tabeli bazfilmow
        DB::table('bazfilmow')->insert([
            [
                'name' => 'Film 1',
                'gatunek' => 1,
                'srednia' => 7.5,
                'ocena' => 8,
                'dodanoprzez' => 'User 1',
                'rokpremiery' => 2020,
                'komentarz' => 'Dobry film',
                'image' => 'film1.jpg',
                'created_at' => '2025-03-15',
                'updated_at' => '2025-03-15',
            ],
            [
                'name' => 'Film 2',
                'gatunek_id' => 2,
                'srednia' => 6.5,
                'ocena' => 7,
                'dodanoprzez' => 'User 2',
                'rokpremiery' => 2019,
                'komentarz' => 'Średni film',
                'image' => 'film2.jpg',
                'created_at' => '2025-03-15',
                'updated_at' => '2025-03-15',
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
