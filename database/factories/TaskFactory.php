<?php

use Faker\Generator as Faker;
use App\Todo;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->slug,      
    ];
});

/*$factory->state(App\Todo::class, 'parent', [
    'parent_id' => null
]);

$factory->state(App\Category::class, 'child', [
    'parent_id' => '0',
]);
*/