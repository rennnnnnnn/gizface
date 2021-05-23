<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'profile_id' => $faker->numberBetween($min = 1, $max = 30),
        'title' => $faker->title,
        'body' => $faker->text,
    ];
});
