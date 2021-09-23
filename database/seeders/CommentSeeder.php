<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            \App\Models\Comment::create([
                'post_id' =>  $i,
                "body" => "body" . $i,
                "user_id" => 1
            ]);
        }
    }
}
