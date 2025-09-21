<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Запуск сидера.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // ищем по email
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), // 🔑 лучше поменять потом
                'is_admin' => true, // если у тебя есть колонка для роли
            ]
        );
    }
}
