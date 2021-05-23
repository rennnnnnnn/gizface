<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CareerDetail;
use Faker\Generator as Faker;

$factory->define(CareerDetail::class, function (Faker $faker) {
    return [
        'career_id' => $faker->numberBetween($min = 1, $max = 30),
        'profile_id' => $faker->numberBetween($min = 1, $max = 30),
        'skill_master_id' => $faker->numberBetween($min = 1, $max = 11),
    ];
});
