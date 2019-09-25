<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tenant;
use App\User;

use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->e164PhoneNumber,
        'user_id' => User::first()->id ?? factory(User::class)->create()->id
    ];
});
