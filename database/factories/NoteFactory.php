<?php

use App\Models\Note;

use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'lead_id'=>  $faker->numberBetween($min = 1, $max = 100),
        'note'=>     $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});
