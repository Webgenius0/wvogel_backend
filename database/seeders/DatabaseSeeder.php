<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            UserSeeder::class,
        ]);
        $this->call([
            CategorySeeder::class,
        ]);
        $this->call([
            HorseSeeder::class,
        ]);
    }
}
