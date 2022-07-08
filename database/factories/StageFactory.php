<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stage;
use Faker\Generator as Faker;

$factory->define(Stage::class, function (Faker $faker) {
    $name = $faker->word();
    return [
        'id' => strtoupper($name),
        'name' => $name
    ];
});
