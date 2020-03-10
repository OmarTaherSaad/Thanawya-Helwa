<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Team\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'title_personal' => $faker->title(),
        'title_on_team' => $faker->title(),
        'user_id' => $faker->randomElement(\App\User::all()->keys()),
        'joined_at' => $faker->date,
        'status' => $faker->randomElement(['founder','old','current']),

    ];
});
