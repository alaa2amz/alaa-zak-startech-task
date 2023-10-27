<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
	    $name=join(' ',fake()->words(2));
	    $slug=Str::slug($name);
        return [
		'name' => $name,
		'slug' => $slug,
		'image' => $slug.'.jpg',
		'description' => fake()->realText(300),


        ];
    }
}
