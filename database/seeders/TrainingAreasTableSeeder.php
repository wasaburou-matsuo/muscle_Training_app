<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//ファザードのDBクラスをインポート
use Illuminate\Support\Facades\DB;

class TrainingAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $training_areas = [
            ['name' => '胸部'],
            ['name' => '肩部'],
            ['name' => '背中'],
            ['name' => '腕'],
            ['name' => '脚'],
            ['name' => '腹筋'],
        ];
        foreach ($training_areas as $c) {
            DB::table('training_areas')->insert($c);
        }    }
}
