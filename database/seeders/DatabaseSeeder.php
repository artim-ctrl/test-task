<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->email(),
            'role' => 'admin',
            'password' => Hash::make('123'),
        ]);

        User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->email(),
            'role' => 'user',
            'password' => Hash::make('123'),
        ]);
    }
}
