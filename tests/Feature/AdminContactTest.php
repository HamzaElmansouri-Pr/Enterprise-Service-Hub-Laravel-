<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminContactTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_contacts_index()
    {
        Contact::factory()->create(['subject' => 'Test Inquiry']);

        $response = $this->actingAs($this->admin)->get(route('admin.contacts.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Inquiry');
    }

    public function test_admin_can_view_contact_details()
    {
        $contact = Contact::factory()->create(['is_read' => false]);

        $response = $this->actingAs($this->admin)->get(route('admin.contacts.show', $contact));

        $response->assertStatus(200);
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'is_read' => 1]);
    }

    public function test_admin_can_delete_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.contacts.destroy', $contact));

        $response->assertRedirect(route('admin.contacts.index'));
        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_admin_can_mark_contact_as_read()
    {
        $contact = Contact::factory()->create(['is_read' => false]);

        $response = $this->actingAs($this->admin)->patch(route('admin.contacts.mark-read', $contact));

        $response->assertRedirect();
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'is_read' => 1]);
    }

    public function test_admin_can_mark_contact_as_unread()
    {
        $contact = Contact::factory()->create(['is_read' => true]);

        $response = $this->actingAs($this->admin)->patch(route('admin.contacts.mark-unread', $contact));

        $response->assertRedirect();
        $this->assertDatabaseHas('contacts', ['id' => $contact->id, 'is_read' => 0]);
    }

    public function test_admin_can_mark_all_contacts_as_read()
    {
        Contact::factory()->count(3)->create(['is_read' => false]);

        $response = $this->actingAs($this->admin)->patch(route('admin.contacts.mark-all-read'));

        $response->assertRedirect();
        $this->assertEquals(0, Contact::where('is_read', false)->count());
    }
}
