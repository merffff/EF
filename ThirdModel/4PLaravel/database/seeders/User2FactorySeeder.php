<?php


namespace Database\Seeders;

use App\Models\User2;
use Illuminate\Database\Seeder;

class User2FactorySeeder extends Seeder
{
    public function run()
    {

        User2::factory()
            ->count(10)
            ->create();
    }
}
