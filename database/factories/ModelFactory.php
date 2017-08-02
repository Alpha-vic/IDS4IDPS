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

use App\Models\Ability;
use App\Models\Camp;
use App\Models\LGA;
use App\Models\Organization;
use App\Models\Person;
use App\Models\Role;
use App\Models\State;
use App\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->firstName,
        'photo' => User::defaultPhotoUrl(),
        'email' => $faker->safeEmail,
        'phone' => $faker->numerify('070########'),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'biography' => $faker->paragraph
    ];
});

//System user, for mimicing user actions
$factory->defineAs(User::class, 'system', function () use ($factory) {
    $user = $factory->raw(User::class);

    return array_merge($user, ['email' => 'admin@ids4idp.com'], ['first_name' => config('app.name')], ['last_name' => '']);
});

$factory->define(Role::class, function (Faker\Generator $faker) {
    $role = $faker->word;

    return [
        'name' => $role,
        'label' => ucfirst($role),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

$factory->defineAs(Role::class, 'admin', function () use ($factory) {
    $role = $factory->raw(Role::class);

    return array_merge($role, ['name' => 'admin']);
});

$factory->defineAs(Role::class, 'deo', function () use ($factory) {
    $role = $factory->raw(Role::class);

    return array_merge($role, ['name' => 'deo']);
});

$factory->define(Ability::class, function (Faker\Generator $faker) {
    return [
        'key' => 'test-ability',
        'description' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

$factory->defineAs(Ability::class, 'admin', function () use ($factory) {
    $ability = $factory->raw(Ability::class);

    return array_merge($ability, ['key' => '*']);
});

$factory->defineAs(Ability::class, 'deo', function () {
    return [];
});

$factory->define(Organization::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->email,
        'phone' => $faker->numerify('070########'),
        'address' => $faker->address,
        'website' => $faker->url,
        'photo' => Organization::defaultPhotoUrl(),
    ];
});

$factory->define(State::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'code' => $faker->countryCode,
    ];
});

$factory->define(LGA::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->city,
        'code' => $faker->countryCode,
    ];
});

$factory->define(Camp::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->streetName,
        'code' => $faker->countryCode,
        'address' => $faker->streetAddress,
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
    ];
});

$factory->define(Person::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'middle_name' => $faker->lastName,
        'last_name' => $faker->lastName,
        'birth_date' => $faker->date('Y-m-d'),
        'sex' => $faker->randomElement(['M', 'F']),
        'height' => $faker->randomFloat(2, 0.5, 10),
        'blood_group' => $faker->randomElement(['A', 'B', 'AB', 'O']),
        'photo' => Person::defaultPhotoUrl(),
        'description' => $faker->realText(500),
        'code' => $faker->unique()->randomNumber(6),
        'status' => Person::STATUS_ENROLLED
    ];
});

