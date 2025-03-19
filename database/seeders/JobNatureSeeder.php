<?php

namespace Database\Seeders;

use App\Models\JobNature;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class JobNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            JobNature::create([
                'name' => $faker->unique()->word()
            ]);
        }
    }
}
