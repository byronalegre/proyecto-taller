<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use App\Http\Models\Pieza;

$factory->define(Pieza::class, function (Faker $faker) {
    return [
    	'codigo'=>$faker->unique()->numberBetween($min = 1000, $max = 9000),
    	'status'=>$faker->randomElement(['0','1']),
    	'name'=>$faker->name,
        'slug'=>$faker->text(12),
        'categoria_id'=>$faker->randomElement(['1','2','3','7','13','14','15','16','17','20','21']),
        'file_path'=>$faker->randomElement(['default']),
        'image'=>$faker->randomElement(['default.png']),
        'cantidad_min'=>$faker->numberBetween($min = 1, $max = 50),
        'cantidad'=>$faker->numberBetween($min = 10, $max = 1000),
        'marca'=>$faker->randomElement(['4','5','6','18','19','22','23','24']),
        'deposito'=>$faker->randomElement(['0','1']),
        'content'=>$faker->paragraph
    ];
});
