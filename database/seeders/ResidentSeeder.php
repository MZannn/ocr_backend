<?php

namespace Database\Seeders;

use App\Models\resident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ResidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            resident::create([
                'identity_number' => $faker->unique()->randomNumber(8),
                'name' => $faker->name,
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
            ]);
        }
    }
}