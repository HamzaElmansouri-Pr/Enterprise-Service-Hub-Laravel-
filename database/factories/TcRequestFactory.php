<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\TcRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class TcRequestFactory extends Factory
{
    protected $model = TcRequest::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'description' => $this->faker->paragraph(),
            'attached_file' => null,
            'service_id' => Service::factory(),
            'status' => 'pending',
            'is_read' => false,
            'read_at' => null,
            'admin_notes' => null,
        ];
    }
}
