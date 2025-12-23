<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin(後臺使用者)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Librarian(圖書館員)
        User::create([
            'name' => 'Librarian',
            'email' => 'librarian@example.com',
            'password' => Hash::make('lib123'),
            'role' => 'librarian',
        ]);

        // Member (一般讀者)
        User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => Hash::make('member123'),
            'role' => 'member',
        ]);
    }
}

