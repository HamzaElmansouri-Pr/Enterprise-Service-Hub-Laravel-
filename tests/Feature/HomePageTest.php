<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\StructureSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\ReviewSeeder;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_correctly_with_cms_data_and_all_modules(): void
    {
        // 1. Run Seeders
        $this->seed(StructureSeeder::class);
        $this->seed(ServiceSeeder::class);
        $this->seed(ProjectSeeder::class);
        $this->seed(BlogSeeder::class);
        $this->seed(ReviewSeeder::class);

        // 2. Visit the homepage
        $response = $this->get('/');

        // 3. Assert Status 200
        $response->assertStatus(200);

        // 4. Assert CMS content
        $response->assertSee('The complete CRM solution built for your success');
        $response->assertSee('What We Offer');
        $response->assertSee('Recent Work');
        $response->assertSee('What our clients say');
        $response->assertSee('Latest News');

        // 5. Assert Service Content
        $response->assertSee('Web Development');

        // 6. Assert Review Content
        // "John Smith" is in test_reviews.csv
        $response->assertSee('John Smith');
        $response->assertSee('Great work on our website');
    }
}
