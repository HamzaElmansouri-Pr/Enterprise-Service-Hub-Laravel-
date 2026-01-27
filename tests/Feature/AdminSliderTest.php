<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Slider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AdminSliderTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
        
        Storage::fake('public');
    }

    public function test_admin_can_view_sliders_index()
    {
        Slider::factory()->create(['title' => 'Test Slider']);

        $response = $this->actingAs($this->admin)->get(route('admin.sliders.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Slider');
    }

    public function test_admin_can_create_slider()
    {
        $file = UploadedFile::fake()->create('slider.jpg', 100);

        $response = $this->actingAs($this->admin)->post(route('admin.sliders.store'), [
            'title' => 'New Slider',
            'subtitle' => 'Subtitle',
            'image' => $file,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.sliders.index'));
        $this->assertDatabaseHas('sliders', ['title' => 'New Slider']);
        Storage::disk('public')->assertExists('sliders/' . $file->hashName());
    }

    public function test_admin_can_update_slider()
    {
        $slider = Slider::factory()->create();
        $newFile = UploadedFile::fake()->create('new.jpg', 100);

        $response = $this->actingAs($this->admin)->put(route('admin.sliders.update', $slider), [
            'title' => 'Updated Slider',
            'subtitle' => 'Updated Subtitle',
            'image' => $newFile,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.sliders.index'));
        $this->assertDatabaseHas('sliders', ['title' => 'Updated Slider']);
    }

    public function test_admin_can_delete_slider()
    {
        $slider = Slider::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.sliders.destroy', $slider));

        $response->assertRedirect(route('admin.sliders.index'));
        $this->assertDatabaseMissing('sliders', ['id' => $slider->id]);
    }
}
