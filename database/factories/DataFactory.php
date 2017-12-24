<?php

use App\Models\Data;
use App\Models\Section;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Crypt;

$factory->define(Data::class, function (Faker $faker) {
    return [
        'name'       => $faker->text(100),
        'data'       => function () use ($faker) {
            $data = [];
            $num  = random_int(1, 5);
            for ($i = 1; $i <= $num; $i++) {
                $data[] = [
                    'label' => $faker->text(20),
                    'value' => $faker->text(20),
                ];
            }

            return $data;
        },
        'section_id' => function () {
            return factory(Section::class)->create()->id;
        },
    ];
});
