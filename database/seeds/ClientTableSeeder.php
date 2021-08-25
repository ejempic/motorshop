<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 60) as $index)
        \App\Clients::create([
            'lname' => $faker->lastName,
            'fname' => $faker->firstName,
            'mname' => $faker->lastName,
            'contact_number_1' => $faker->phoneNumber,
            'contact_number_2' => $faker->phoneNumber,
            'email' => $faker->email,
            'marital_status' => $faker->randomElement(['single', 'married', 'annulled/divorced', 'window/er']),
            'dob' => $faker->date('Y-m-d'),
            'address' => $faker->streetAddress,
            'barangay' => $faker->randomElement([
                "ALCALA",
                "ALOBO",
                "ANISLAG",
                "BAGUMBAYAN",
                "BALINAD",
                "BAÑADERO",
                "BAÑAG",
                "BASCARAN",
                "BIGAO",
                "BINITAYAN",
                "BONGALON",
                "BUDIAO",
                "BURGOS",
                "BUSAY",
                "CANAROM",
                "CULLAT",
                "DELA PAZ",
                "DINORONAN",
                "GABAWAN",
                "GAPO",
                "IBAUGAN",
                "ILAWOD AREA POB. (DIST. 2)",
                "INARADO",
                "KIDACO",
                "KILICAO",
                "KIMANTONG",
                "KINAWITAN",
                "KIWALO",
                "LACAG",
                "MABINI",
                "MALABOG",
                "MALOBAGO",
                "MAOPI",
                "MARKET AREA POB. (DIST. 1)",
                "MAROROY",
                "MATNOG",
                "MAYON",
                "MI-ISI",
                "NABASAN",
                "NAMANTAO",
                "PANDAN",
                "PEÑAFRANCIA",
                "SAGPON",
                "SALVACION",
                "SAN RAFAEL",
                "SAN RAMON",
                "SAN ROQUE",
                "SAN VICENTE GRANDE",
                "SAN VICENTE PEQUEÑO",
                "SIPI",
                "TABON-TABON",
                "TAGAS",
                "TALAHIB",
                "VILLAHERMOSA"
            ]),
            'city' => "DARAGA",
            'province' => "ALABAY",
            'remarks' => $faker->paragraph(4),
        ]);
    }
}
