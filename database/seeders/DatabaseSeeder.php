<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(AdminUserSeeder::class);

        // Создаем категории
        $categories = ['Здоровье', 'Медицина', 'Заболевания'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }

        // Берем первого пользователя для связи с статьями
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create(); // если нет, создаем
        }

        // Создаем статьи
        for ($i = 1; $i <= 10; $i++) {
            Article::create([
                'user_id' => $user->id,
                'category_id' => Category::inRandomOrder()->first()->id,
                'title' => "Статья $i",
                'content' => strtolower(Str::random(200)), // случайный текст 200 символов
                'image' => "articles/image{$i}.jpg",
            ]);
        }
    }

}
