<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(3, true);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'subtitle' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'icon' => 'flaticon-settings',
            'image' => null,
            'is_active' => true,
            'order_index' => fake()->numberBetween(0, 10),
        ];
    }
}
