<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'role_id'=> $faker->numberBetween($min = 2, $max = 3), // 1 is for admin
        'status'=> 'active',
        'email_verified_at' => now(),
        'password' => '$2y$10$0hJwwcF9nScQRH2Xhzz69uI8HuZWHkdWLJ3SQ.8iMKLAu9iNgxcTq', // mandaladwipantara.co.id
        'remember_token' => Str::random(10),
    ];
});
