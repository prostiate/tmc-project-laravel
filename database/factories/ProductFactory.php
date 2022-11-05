<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'categories_id' => Category::inRandomOrder()->first()->id,
            'sku' => $this->faker->name(),
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(6),
            'stock' => $this->faker->randomNumber(3),
        ];
    }
}
