<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//DBファザードの使用を定義
use Illuminate\Support\Facades\DB;

class TrainingEquipmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //training_resultsテーブルからidだけ、配列として取得。外部キー制約があるため
        $training_results = DB::table('training_results')->pluck('id')->toArray();
        //器具の名前を配列として定義
        $training_equipments_names = ['Bench Press Bench', 'Dumbbell', 'Pull-up Machine', 'Shoulder Press Machine', 'Ab Roller', 'Deadlift Bar', 'Dumbbell', 'Pull-up Machine'];


        foreach ($training_equipments_names as $training_equipments_name) {
            for ($i = 0; $i < rand(2, 5); $i++) { // Each recipe will have 2 to 5 ingredients
                DB::table('training_equipments')->insert([
                    'training_results_id' => $training_results,
                    //array_
                    rand関数で、指定した配列のキーを取得
                    // 'name' => $training_equipments_names[array_rand($training_equipments_names)],
                    // 'name' => $training_equipments_names[1],
                    'name' => $training_equipments_names[array_rand($training_equipments_names)],
                    'weight' => rand(1, 100) . 'kg', // Random weight between 1 and 100 kgrams
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
