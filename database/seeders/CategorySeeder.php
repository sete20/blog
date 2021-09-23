<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            \App\Models\Category::create([
                'name' => "name" . $i,
                'slug' => "slug" . $i
            ]);
        }
    }
}
