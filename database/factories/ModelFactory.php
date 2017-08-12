<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $user = [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'gender' => 1,
        'dob' => '1997-03-16',
        'slug' => $faker->name,
        'avatar' => 'public/defaults/avatars/male.png',
        'password' => $password ?: $password = bcrypt('secret')
    ];
    $role = Sentinel::findRoleByName('Sponser');
    $user->roles()->attach($role);
});
