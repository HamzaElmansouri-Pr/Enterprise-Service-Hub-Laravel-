<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->url(),
            'company' => $this->faker->company(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'is_read' => false,
            'read_at' => null,
        ];
    }
}
