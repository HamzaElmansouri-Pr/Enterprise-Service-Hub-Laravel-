<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraphs(3, true),
            'client' => $this->faker->company(),
            'completion_date' => $this->faker->date(),
            'category' => $this->faker->randomElement(['Web Development', 'Mobile App', 'SEO', 'Marketing']),
            'image' => 'assets/img/project/0' . $this->faker->numberBetween(1, 5) . '.jpg',
            'is_active' => true,
            'order_index' => $this->faker->numberBetween(1, 10),
        ];
    }
}
