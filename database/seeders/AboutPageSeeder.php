<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the about page section
        $aboutSection = Section::where('key', 'about-main')->first();

        if ($aboutSection) {
            $aboutSection->update([
                'title' => 'About Nova Agency',
                'subtitle' => 'Pioneering Digital Transformation',
                'content' => 'Nova Agency is a leading digital transformation consultancy dedicated to empowering enterprises through innovative technology solutions. Our team of world-class experts specializes in software development, cloud architecture, and artificial intelligence.',
                'meta_data' => [
                    'stats' => [
                        ['label' => 'Projects Delivered', 'value' => '150+'],
                        ['label' => 'Expert Team Members', 'value' => '45'],
                        ['label' => 'Years Experience', 'value' => '10'],
                        ['label' => 'Client Satisfaction', 'value' => '99%'],
                    ],
                    'values' => [
                        ['title' => 'Innovation', 'description' => 'We push boundaries to deliver cutting-edge solutions.'],
                        ['title' => 'Excellence', 'description' => 'Quality is at the core of everything we build.'],
                        ['title' => 'Integrity', 'description' => 'We maintain the highest standards of transparency and ethics.'],
                    ],
                    'team' => [
                        ['name' => 'Sarah Connor', 'role' => 'Chief Executive Officer', 'image' => null],
                        ['name' => 'John Smith', 'role' => 'CTO', 'image' => null],
                        ['name' => 'Elena Rodriguez', 'role' => 'Head of Design', 'image' => null],
                    ]
                ],
            ]);
        } else {
            Section::create([
                'key' => 'about-main',
                'type' => 'page-content',
                'title' => 'About Nova Agency',
                'subtitle' => 'Pioneering Digital Transformation',
                'content' => 'Nova Agency is a leading digital transformation consultancy dedicated to empowering enterprises through innovative technology solutions. Our team of world-class experts specializes in software development, cloud architecture, and artificial intelligence.',
                'is_active' => true,
                'meta_data' => [
                    'stats' => [
                        ['label' => 'Projects Delivered', 'value' => '150+'],
                        ['label' => 'Expert Team Members', 'value' => '45'],
                        ['label' => 'Years Experience', 'value' => '10'],
                        ['label' => 'Client Satisfaction', 'value' => '99%'],
                    ],
                    'values' => [
                        ['title' => 'Innovation', 'description' => 'We push boundaries to deliver cutting-edge solutions.'],
                        ['title' => 'Excellence', 'description' => 'Quality is at the core of everything we build.'],
                        ['title' => 'Integrity', 'description' => 'We maintain the highest standards of transparency and ethics.'],
                    ],
                    'team' => [
                        ['name' => 'Sarah Connor', 'role' => 'Chief Executive Officer', 'image' => null],
                        ['name' => 'John Smith', 'role' => 'CTO', 'image' => null],
                        ['name' => 'Elena Rodriguez', 'role' => 'Head of Design', 'image' => null],
                    ]
                ],
            ]);
        }
    }
}
