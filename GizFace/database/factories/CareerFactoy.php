<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Career;
use Faker\Generator as Faker;

$factory->define(Career::class, function (Faker $faker) {
    static $number = 1;
    $randomDate = [null, $faker->dateTimeBetween('-4 years', 'now')->format('Y-m-01')];
    return [
        'profile_id' => $number++,
        'from' => $faker->dateTimeBetween('-5 years', '-1years')->format('Y-m-01'), // (1〜5年前の日付)
        'to' => $faker->randomElement($randomDate),
        'company' =>  $faker->company(),
        'job_title' => $faker->sentence(1),
        'job_detail' => $faker->text(),
        'team_scale' => $faker->numberBetween($min = 2, $max = 30),
        'sort' => $faker->numberBetween($min = 1, $max = 30),
    ];
});
