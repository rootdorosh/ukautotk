<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Modules\User\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Role::class, function (Faker $faker) {
    $name = $faker->name;
    
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => $faker->text(80),
    ];
});
