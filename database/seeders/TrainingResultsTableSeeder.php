<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//ファザードのDBクラスをインポート
use Illuminate\Support\Facades\DB;
//helper機能
use Illuminate\Support\str;

class TrainingResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $training_areas = DB::table('training_areas')->pluck('id')->toArray();
        $users = DB::table('users')->pluck('id')->toArray();

        $image_types = ['Weight Training', 'Bodyweight Training', 'Cardiovascular Exercise', 'High-Intensity Interval Training (HIIT)', 'Functional Training', 'CrossFit', 'Periodization Training', 'Isometric Training', 'Balance Ball Exercises', 'Neuromuscular Proprioceptive Training (NPT)', 'Plyometric Training'];

        //20個のトレーニング実績２０個を作成
        for ($i = 0; $i < 20; $i++) {
            DB::table('training_results')->insert([
                'id' => Str::uuid(),
                //usersテーブルからランダムに取得したidをusers_idとして設定
                //usersテーブルに実際にあるidの為、外部キー制約に引っかからない。
                'user_id' => $users[array_rand($users)],
                //training_areasテーブルからランダムに取得したidをusers_idとして設定
                //training_areasテーブルに実際にあるidの為、外部キー制約に引っかからない。
                'training_areas_id' => $training_areas[array_rand($training_areas)],
                'title' => 'Training of ' . Str::random(10),
                'description' => 'This is a sample Training description for ' . Str::random(10),
                'image' => 'https://source.unsplash.com/random/?' . $image_types[rand(0, 10)],
                'views' => rand(0, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }    
    }
}
