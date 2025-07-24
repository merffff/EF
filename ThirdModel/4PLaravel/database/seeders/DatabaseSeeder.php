<?php

namespace Database\Seeders;

use App\Models\User2;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\User2Factory;
use Illuminate\Database\Seeder;
use Database\Seeders\User2FactorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            User2Seeder::class,
        ]);
        $this->call([
            User2FactorySeeder::class,
        ]);
    }
}
