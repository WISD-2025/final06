<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@final06.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin12345!'),
                'role' => 'librarian',
            ]
        );
    }
}
