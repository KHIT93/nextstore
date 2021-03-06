<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Product::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word),
        'teaser' => $faker->sentence,
        'category_id' => null,
        'description' => $faker->paragraph,
        'body' => $faker->paragraph,
        'price' => 0
    ];
});
