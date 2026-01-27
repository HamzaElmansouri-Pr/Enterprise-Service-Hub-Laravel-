<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\TcRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FormSubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_contact_form_submission_success(): void
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '1234567890',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
        ];

        $response = $this->post(route('contact.submit'), $data);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'email' => $data['email'],
            'subject' => 'Test Subject',
        ]);
    }

    public function test_contact_form_validation(): void
    {
        $response = $this->post(route('contact.submit'), []);
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    public function test_tc_request_submission_success(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $data = [
            'email' => $this->faker->email,
            'description' => 'I need help with this project.',
            'file' => $file,
        ];

        $response = $this->post(route('tc-request.submit'), $data);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('tc_requests', [
            'email' => $data['email'],
        ]);
        
        // Assert file was stored
        // In the controller we use $request->file('file')->store('tc-requests', 'public')
        // So we check if a file exists in that directory
        // Since the filename is hashed, we can just check if any file exists there or trust the database record
        
        $request = TcRequest::first();
        $this->assertNotNull($request->attached_file);
        Storage::disk('public')->assertExists($request->attached_file);
    }
}
