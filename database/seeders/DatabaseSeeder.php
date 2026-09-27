<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['Sinian', 'Luca', 'Xavier', 'Wanda'] as $name) {
            User::factory()->create([
                'name' => $name,
                'email' => strtolower($name).'@peoplefone.com',
            ]);
        }
    }
}
