<?php

use App\Models\Section;
use App\Models\Site;
use Faker\Generator as Faker;

$factory->define(Section::class, function (Faker $faker) {
    return [
        'name' => $faker->text(100),
        'site_id' => function () {
            return factory(Site::class)->create()->id;
        }
    ];
});
