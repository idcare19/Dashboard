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
        User::query()->updateOrCreate(
            ['email' => 'dream1mm113@gmail.com'],
            [
                'name' => 'Abhishek Admin',
                'password' => 'fakeavi09',
                'role' => 'admin',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'normal.user@example.com'],
            [
                'name' => 'Normal User',
                'password' => 'password123',
                'role' => 'user',
            ]
        );
    }
}
