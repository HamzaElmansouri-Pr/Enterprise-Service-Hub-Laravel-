<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure storage directory exists
        if (!Storage::disk('public')->exists('sliders')) {
            Storage::disk('public')->makeDirectory('sliders');
        }

        // Define source images from the template assets
        $images = [
            'slide1.jpg' => public_path('assets/img/home-1/hero/hero-bg.jpg'),
            'slide2.jpg' => public_path('assets/img/home-2/hero/hero-bg.jpg'),
            'slide3.jpg' => public_path('assets/img/home-2/technology-bg.jpg'), 
        ];

        // If specific home images aren't found, fallback to generic ones
        if (!File::exists($images['slide3.jpg'])) {
             $images['slide3.jpg'] = public_path('assets/img/cta-bg.jpg');
        }

        // Copy images to storage
        foreach ($images as $targetName => $sourcePath) {
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put('sliders/' . $targetName, File::get($sourcePath));
            }
        }

        // Create sample sliders
        $sliders = [
            [
                'title' => 'Innovative IT Solutions',
                'subtitle' => 'Empowering your business with cutting-edge technology and support.',
                'image' => 'sliders/slide1.jpg',
                'button_text' => 'Get Started',
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Secure Cloud Services',
                'subtitle' => 'Reliable and scalable cloud infrastructure for modern enterprises.',
                'image' => 'sliders/slide2.jpg',
                'button_text' => 'Our Services',
                'button_url' => '/services',
                'is_active' => true,
                'sort_order' => 2,
            ],
             [
                'title' => 'Professional Consulting',
                'subtitle' => 'Expert advice to navigate your digital transformation journey.',
                'image' => 'sliders/slide3.jpg',
                'button_text' => 'About Us',
                'button_url' => '/about',
                'is_active' => true,
                'sort_order' => 3,
            ]
        ];
        
        // Clear existing sliders to avoid duplicates during development
        Slider::truncate();

        foreach ($sliders as $sliderData) {
            Slider::create($sliderData);
        }
    }
}
