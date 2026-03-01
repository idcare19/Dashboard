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
        if (! app()->environment(['local', 'testing']) && ! filter_var(env('ALLOW_PRODUCTION_SEED', false), FILTER_VALIDATE_BOOL)) {
            return;
        }

        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('SEED_ADMIN_PASSWORD', 'ChangeMeNow!123');
        $userEmail = env('SEED_USER_EMAIL', 'user@example.com');
        $userPassword = env('SEED_USER_PASSWORD', 'ChangeMeNow!123');

        User::query()->updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Abhishek Admin',
                'password' => $adminPassword,
                'role' => 'admin',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => $userEmail],
            [
                'name' => 'Normal User',
                'password' => $userPassword,
                'role' => 'user',
            ]
        );
    }
}
