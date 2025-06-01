<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- tambahkan ini
use Illuminate\Support\Str;          // <-- dan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
    'name' => 'Admin',
    'email' => 'admin@gmail.com',
    'username' => 'admin',
    'email_verified_at' => now(),
    'password' => Hash::make('1234'),
    'remember_token' => Str::random(10),
]);


    }
}
