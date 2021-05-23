<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    static $number = 1;
    return [
        'gender' => $faker->randomElement($array = [0, 1]),
        'birthday' => $faker->dateTimeBetween('-40 years', '-20years')->format('Y-m-d'),
        'description' => $faker->text(),
        'profile_image_path' => '/img/profile.png',
        'joined_company_date' => $faker->dateTimeBetween('-5 years', '-1years')->format('Y-m-d'), // (1〜5年前の日付)
        'joined_project_date' => $faker->dateTimeBetween('-5 years', '-1years')->format('Y-m-01'),
        'address' => $faker->address(),
        'github_url' => $faker->url,
        'user_id' => $number++,
    ];
});
