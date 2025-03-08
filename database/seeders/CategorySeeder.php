<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            DB::table('categories')->insert([
                [
                    'category_name' => 'Available Horse',
                    'category_description' => 'Available Horse',
                ],
                [
                    'category_name' => 'Horse For Sale',
                    'category_description' => 'Horse For Sale',
                ],
                [
                    'category_name' => 'Horse Rental',
                    'category_description' => 'Horse Rental',
                ],
            ]);
        }
    }
}
