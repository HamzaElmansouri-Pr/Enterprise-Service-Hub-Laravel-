<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\StructureSeeder;
use Database\Seeders\ServiceSeeder;
use App\Models\Service;

class ServicePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_index_page_loads(): void
    {
        $this->seed(StructureSeeder::class);
        $this->seed(ServiceSeeder::class);

        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Web Development');
    }

    public function test_service_detail_page_loads(): void
    {
        $this->seed(StructureSeeder::class);
        $this->seed(ServiceSeeder::class);

        // Ensure we retrieve a service that was seeded
        $service = Service::where('slug', 'web-development')->firstOrFail();

        $response = $this->get('/services/' . $service->slug);

        $response->assertStatus(200);
        $response->assertSee($service->title);
    }
}
