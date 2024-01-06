<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//DBファザードの使用を定義
use Illuminate\Support\Facades\DB;

class TrainingReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $training_results = DB::table('training_results')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();
        $comments = ['Great training!', 'I loved it!', 'Will try again.', 'Not my favorite.', 'Easy!'];

        foreach ($training_results as $training_result) {
            for ($i = 0; $i < rand(1, 3); $i++) { // Each recipe will have 1 to 3 reviews
                DB::table('training_reviews')->insert([
                    'user_id' => $users[array_rand($users)],
                    'training_results_id' => $training_result,
                    'rating' => rand(1, 5),
                    'comment' => $comments[array_rand($comments)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
