<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++)
        {
            Article::create([
                'user_id' => 1, 'title' => 'Dit is een ziek artikel #' . $i,
                'introduction' => 'Dit is de bescrhijving van artikel #' . $i,
                'content' => 'Er moet hier dus ook nog een beetje inhoud aan worden toegevoegd',
                'start_date' => '2022-09-10',
                'end_date' => '2023-09-10'
            ]);
        }
    }
}
