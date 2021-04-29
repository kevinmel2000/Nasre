<?php

use App\Models\Leads\Lead;
use Faker\Generator as Faker;

$factory->define(Lead::class, function (Faker $faker) {
    $is_dead = $faker->randomElement($array = array ('yes','no'));
    return [
        'lead_source_id'=>  $faker->numberBetween($min = 1, $max = 24),
        'lead_status_id'=>  $faker->numberBetween($min = 1, $max = 6),
        'title_id'=>        $faker->numberBetween($min = 1, $max = 6),
        'user_id'=>         $faker->numberBetween($min = 1, $max = 5),
        'owner_id'=>        $faker->numberBetween($min = 1, $max = 10),
        'lead_temprature'=> $faker->randomElement($array = array ('Hot','Warm','Cold')),
        'score'=>           $faker->numberBetween($min = 1, $max = 10),
        'first_name'=>      $faker->firstName($gender = 'male'|'female'|'other'),
        'last_name'=>       $faker->lastName,
        'company_name'=>    $faker->company,
        'industry_id'=>     $faker->numberBetween($min = 1, $max = 10),
        'language_id'=>     $faker->numberBetween($min = 1, $max = 10),
        'email'=>           $faker->unique()->safeEmail,
        'phone'=>           $faker->e164PhoneNumber,
        'is_dead'=>         $is_dead,
        'is_poor_fit'=>     ($is_dead == 'yes') ? 'no' : $faker->randomElement($array = array ('yes','no')),
        'created_at'=>      $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
    ];
});
