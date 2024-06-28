<?php

namespace Database\Seeders;

use App\Models\DiaFestivo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'surname' => 'Test User',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => 'adminadmin',
            'email_verified_at' => now(),
        ]);

        User::factory()->count(50)->create();

        DiaFestivo::factory()->count(25)->create();
    }
}
