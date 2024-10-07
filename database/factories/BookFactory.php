<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'publisher' => $this->faker->company,
            'author' => $this->faker->name,
            'genre' => $this->faker->word,
            'publication' => $this->faker->date(),
            'words' => $this->faker->numberBetween(10000, 100000),
            'price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
