<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            \App\Models\Post::create([
                'title' => "title" . $i,
                'slug' => "slug" . $i,
                "body" => "body" . $i,
                "user_id" => 1,
                'category_id' => $i
            ]);
        }
    }
}
