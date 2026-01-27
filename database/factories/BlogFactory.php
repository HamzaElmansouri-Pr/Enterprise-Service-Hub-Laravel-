<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(5);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(5, true),
            'excerpt' => $this->faker->paragraph(),
            'image' => 'assets/img/blog/0' . $this->faker->numberBetween(1, 3) . '.jpg',
            'author_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_active' => true,
            'category' => $this->faker->randomElement(['Technology', 'Business', 'Design', 'Development']),
        ];
    }
}
