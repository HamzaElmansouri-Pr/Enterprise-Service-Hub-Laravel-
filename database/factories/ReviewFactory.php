<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'client_position' => fake()->jobTitle(),
            'client_company' => fake()->company(),
            'client_image' => null, // Placeholder or null
            'review_text' => fake()->paragraph(),
            'rating' => fake()->numberBetween(4, 5),
            'project_type' => fake()->randomElement(['Web Development', 'Digital Marketing', 'SEO', 'App Development']),
            'is_featured' => fake()->boolean(20),
            'is_active' => true,
            'order_index' => fake()->numberBetween(0, 100),
        ];
    }
}
