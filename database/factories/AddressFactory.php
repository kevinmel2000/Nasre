<?php

use Faker\Generator as Faker;
use App\Models\Address\Address;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'lead_id'=>  $faker->numberBetween($min = 1, $max = 100),
        'country_id'=>  $faker->numberBetween($min = 1, $max = 245),
        'state_id'=>  0,
        'city_id'=>  0,
        "address_line_1" => $faker->address,
        "address_line_2" => $faker->secondaryAddress,
    ];
});
