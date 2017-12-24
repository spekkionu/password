<?php

use App\Models\Site;
use Faker\Generator as Faker;

$factory->define(Site::class, function (Faker $faker) {
    return [
        'name' => $faker->text(100),
        'domain' => $faker->domainName,
        'notes' => $faker->paragraph
    ];
});
