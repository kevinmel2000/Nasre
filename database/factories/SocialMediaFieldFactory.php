<?php

use Faker\Generator as Faker;
use App\Models\SocialMediaField;

$factory->define(SocialMediaField::class, function (Faker $faker) {
    return [
        'lead_id'=>  $faker->numberBetween($min = 1, $max = 100),
        "facebook" => $faker->username,
        "twitter" => $faker->username,
    ];
});
