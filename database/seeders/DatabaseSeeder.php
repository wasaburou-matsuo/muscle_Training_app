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
        //seedコマンドを打つと、このファイルが読まれ、各seederファイルが順に呼ばれる。
        //外部キー制約に引っかからないように、定義する順番が重要！！
        $this->call([
            UsersTableSeeder::class,
            TrainingAreasTableSeeder::class,
            TrainingResultsTableSeeder::class,
            TrainingEventsTableSeeder::class,
            TrainingEquipmentsTableSeeder::class,
            TrainingReviewsTableSeeder::class
        ]);
    }
}
