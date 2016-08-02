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

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'api_token' => $faker->name,
        'company_id' => 1,
    ];
});

$factory->define(App\Entities\MySql\KeyMySql::class, function ($faker) {
    return [
        'entity_key' => 'vehicle',
        'description' => 'Description',
        'type' => 'string',
    ];
});

$factory->define(App\Entities\MySql\ValueMySql::class, function ($faker) {
    return [
        'entity_key' => 'vehicle',
        'entity_id' => 1,
        'attribute_id' => 1,
        'value' => 1,
    ];
});
        