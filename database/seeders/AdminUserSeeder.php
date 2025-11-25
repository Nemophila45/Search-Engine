<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin RSUD',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
                'email_verified_at' => now(),
            ],
        );

        User::updateOrCreate(
            ['email' => 'dokter@example.com'],
            [
                'name' => 'dr. RSUD',
                'password' => Hash::make('password'),
                'role' => UserRole::DOCTOR,
                'email_verified_at' => now(),
            ],
        );

        User::updateOrCreate(
            ['email' => 'koas@example.com'],
            [
                'name' => 'Koas RSUD',
                'password' => Hash::make('password'),
                'role' => UserRole::KOAS,
                'email_verified_at' => now(),
            ],
        );
    }
}
