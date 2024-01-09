<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(10)->create();
        \App\Models\Post::factory(10)->create();
        \App\Models\Join::factory(10)->create();
        \App\Models\Tag::factory(1)->create(['tagName'=>'Hotel']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Travel']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Movie']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Books']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Music']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Anime']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'World']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Feast']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Vehicle']);
        \App\Models\Tag::factory(1)->create(['tagName'=>'Animal']);
        \App\Models\Rating::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
