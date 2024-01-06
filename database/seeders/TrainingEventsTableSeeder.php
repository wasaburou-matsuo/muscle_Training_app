<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//DBファザードの使用を定義
use Illuminate\Support\Facades\DB;


class TrainingEventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $training_results = DB::table('training_results')->pluck('id')->toArray();

        foreach ($training_results as $training_resultsId) {
            $numberOfSteps = rand(3, 6); // Randomly generate between 3 to 6 steps for each training

            for ($i = 1; $i <= $numberOfSteps; $i++) {
                DB::table('training_events')->insert([
                    'training_results_id' => $training_resultsId,
                    'step_number' => $i,
                    'description' => 'Step ' . $i . ' description for training ' . $training_resultsId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
