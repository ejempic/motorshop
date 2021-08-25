<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 20) as $index)
        \App\Units::create([
            'plate_no' => $faker->randomNumber(3).ucwords($faker->randomLetter()).ucwords($faker->randomLetter()).ucwords($faker->randomLetter()),
            'engine_no' => $faker->randomNumber(9),
            'chassis_no' => $faker->randomNumber(9),
            'brand' => $faker->randomElement(['brand 1', 'brand 2']),
            'model' => $faker->randomElement(['Model A', 'Model B', 'Model C']),
            'color' => $faker->randomElement(['black', 'red', 'blue']),
            'type' => $faker->randomElement(['Standard', 'Cruiser', 'Scooter']),
            'bnew_repo' => $faker->randomElement(['bnew', 'repo']),
            'remarks' => $faker->paragraph,
        ]);
    }
}
