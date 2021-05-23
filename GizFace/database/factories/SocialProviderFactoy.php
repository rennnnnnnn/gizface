<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SocialProvider;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(SocialProvider::class, function (Faker $faker) {
    static $number = 1;
    return [
        'provider_id' => $faker->unique()->uuid,
        'provider_name' => 'slack',
        'unique_key' => Str::random(10),
        'user_id' => $number++,
    ];
});
