<?php

namespace Tests\Feature;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminReviewTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create admin user
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_reviews_index()
    {
        Review::factory()->create(['client_name' => 'Test Reviewer']);

        $response = $this->actingAs($this->admin)->get(route('admin.reviews.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Reviewer');
    }

    public function test_admin_can_create_review()
    {
        $data = [
            'client_name' => 'New Client',
            'client_company' => 'New Company',
            'review_text' => 'Great service!',
            'rating' => 5,
            'is_active' => '1',
            'order_index' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.reviews.store'), $data);

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseHas('reviews', ['client_name' => 'New Client', 'review_text' => 'Great service!']);
    }

    public function test_admin_can_update_review()
    {
        $review = Review::factory()->create();

        $data = [
            'client_name' => 'Updated Client',
            'client_company' => 'Updated Company',
            'review_text' => 'Updated feedback',
            'rating' => 4,
            'is_active' => '1',
            'order_index' => 2,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.reviews.update', $review), $data);

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'client_name' => 'Updated Client']);
    }

    public function test_admin_can_delete_review()
    {
        $review = Review::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.reviews.destroy', $review));

        $response->assertRedirect(route('admin.reviews.index'));
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }
}
