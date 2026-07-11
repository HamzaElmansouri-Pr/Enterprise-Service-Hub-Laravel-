<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\TcRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CloudinaryUploadService;
use Mockery;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Set storage disk to public for local testing
        config(['filesystems.default' => 'public']);
    }

    public function test_service_creation_with_local_image_upload()
    {
        Storage::fake('public');
        
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $this->actingAs($admin);

        $file = UploadedFile::fake()->image('service.jpg');

        $payload = [
            'title' => ['en' => 'Test Service'],
            'slug' => 'test-service',
            'short_description' => ['en' => 'Short desc'],
            'long_description' => ['en' => 'Long desc'],
            'description' => ['en' => 'Desc'],
            'subtitle' => ['en' => 'Subtitle'],
            'icon' => 'fa-star',
            'image' => $file,
            'is_active' => 1,
            'order_index' => 1
        ];

        $response = $this->post(route('admin.services.store'), $payload);
        $response->assertRedirect(route('admin.services.index'));

        $service = Service::where('slug', 'test-service')->first();
        $this->assertNotNull($service);
        $this->assertStringStartsWith('storage/services/', $service->image);

        // Assert file exists on the fake disk
        $filePath = str_replace('storage/', '', $service->image);
        Storage::disk('public')->assertExists($filePath);
    }

    public function test_service_creation_with_cloudinary_upload()
    {
        config(['filesystems.default' => 'cloudinary']);

        // Mock the CloudinaryUploadService
        $mockService = Mockery::mock(CloudinaryUploadService::class);
        $mockService->shouldReceive('upload')
            ->once()
            ->andReturn('https://res.cloudinary.com/demo/image/upload/v1/services/mocked.jpg');
            
        $this->app->instance(CloudinaryUploadService::class, $mockService);

        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $this->actingAs($admin);

        $file = UploadedFile::fake()->image('service_cloud.jpg');

        $payload = [
            'title' => ['en' => 'Cloud Service'],
            'slug' => 'cloud-service',
            'short_description' => ['en' => 'Short desc'],
            'long_description' => ['en' => 'Long desc'],
            'description' => ['en' => 'Desc'],
            'subtitle' => ['en' => 'Subtitle'],
            'icon' => 'fa-cloud',
            'image' => $file,
            'is_active' => 1,
            'order_index' => 2
        ];

        $response = $this->post(route('admin.services.store'), $payload);
        $response->assertRedirect(route('admin.services.index'));

        $service = Service::where('slug', 'cloud-service')->first();
        $this->assertEquals('https://res.cloudinary.com/demo/image/upload/v1/services/mocked.jpg', $service->image);
    }

    public function test_api_tc_request_with_file_attachment_local()
    {
        Storage::fake('public');
        
        Storage::fake('local');
        
        $mockService = Mockery::mock(CloudinaryUploadService::class);
        $mockService->shouldReceive('uploadFileFromPath')
            ->once()
            ->andReturn('storage/tc-requests/mocked.pdf');
            
        $this->app->instance(CloudinaryUploadService::class, $mockService);

        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $payload = [
            'name' => 'John Requester',
            'email' => 'john.req@example.com',
            'service_id' => null,
            'description' => 'Need help with this document',
            'attached_file' => $file
        ];

        $response = $this->postJson('/api/v1/tc-request', $payload);
        
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Your request has been received. Our team will review it shortly.']);

        $tcRequest = TcRequest::where('email', 'john.req@example.com')->first();
        $this->assertNotNull($tcRequest);
        $this->assertStringStartsWith('storage/tc-requests/', $tcRequest->attached_file);

        $this->assertEquals('storage/tc-requests/mocked.pdf', $tcRequest->attached_file);
    }
}
