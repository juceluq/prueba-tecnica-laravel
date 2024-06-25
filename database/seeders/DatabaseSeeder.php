<?php

namespace Database\Seeders;

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
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
        ]);

        User::factory()->create([
            'name' => 'Jane',
            'surname' => 'Smith',
            'email' => 'jane.smith@example.com',
        ]);

        User::factory()->create([
            'name' => 'Michael',
            'surname' => 'Johnson',
            'email' => 'michael.johnson@example.com',
        ]);

        User::factory()->create([
            'name' => 'Custom',
            'surname' => 'User 1',
            'email' => 'custom.user1@example.com',
        ]);
        
        User::factory()->create([
            'name' => 'Custom',
            'surname' => 'User 2',
            'email' => 'custom.user2@example.com',
        ]);
     
        User::factory()->count(50)->create();
    }
}
