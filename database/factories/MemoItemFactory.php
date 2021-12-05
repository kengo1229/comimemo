<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MemoItem;
use Faker\Generator as Faker;

$factory->define(MemoItem::class, function (Faker $faker) {
    return [
        'memo_id' => 1,
        'comic_title' => $faker->name,
        'comic_number' => 1,
        'order' => 1
    ];
});
