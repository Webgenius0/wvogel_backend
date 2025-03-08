<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('horses')->insert([
            [
                'category_id' => 1,
                'name' => 'Thunder Bolt',
                'about_horse' => 'A fast and powerful racing horse.',
                'horse_image' => 'horses/thunder_bolt.jpg',
                'racing_start' => 20,
                'racing_win' => 10,
                'racing_place' => 5,
                'racing_show' => 3,
                'breed' => 'Thoroughbred',
                'gender' => 'Male',
                'age' => '5 years',
                'trainer' => 'John Doe',
                'owner' => 'Elite Racing Club',
            ],
            [
                'category_id' => 2,
                'name' => 'Shadow Runner',
                'about_horse' => 'Known for its speed in short sprints.',
                'horse_image' => 'horses/shadow_runner.jpg',
                'racing_start' => 15,
                'racing_win' => 7,
                'racing_place' => 4,
                'racing_show' => 2,
                'breed' => 'Arabian',
                'gender' => 'Female',
                'age' => '4 years',
                'trainer' => 'Mike Smith',
                'owner' => 'Sunset Stables',
            ],
            [
                'category_id' => 3,
                'name' => 'Golden Hoof',
                'about_horse' => 'An experienced champion horse.',
                'horse_image' => 'horses/golden_hoof.jpg',
                'racing_start' => 30,
                'racing_win' => 15,
                'racing_place' => 8,
                'racing_show' => 5,
                'breed' => 'Quarter Horse',
                'gender' => 'Male',
                'age' => '6 years',
                'trainer' => 'Sarah Williams',
                'owner' => 'Champion Horse Farms',

            ]
        ]);
    }
}
