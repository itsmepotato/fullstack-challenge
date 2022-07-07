<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Card;
use App\Stage;
use App\User;
use Faker\Generator as Faker;

$factory->define(Card::class, function (Faker $faker) {
    $user = User::first() ?? factory(User::class)->create();
    $stage = Stage::first() ?? factory(Stage::class)->create();
    return [
        'user_id' => $user->id,
        'stage_id' => $stage->id
    ];
});
