<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Section;
use App\Models\ContentBlock;

class StructureSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Home Page
        $homePage = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Home',
                'meta_description' => 'Nova Agency - Complete IT Services & Technology Solutions',
                'is_active' => true,
                'is_home' => true
            ]
        );

        // 2. Clear existing sections for idempotency
        $homePage->sections()->delete();

        // 3. Define Sections Structure
        $sections = [
            [
                'name' => 'Hero Section',
                'type' => 'hero-3',
                'order_index' => 1,
                'content' => [
                    'title' => 'The complete IT solution built for your success',
                    'subtitle' => 'All your technology infrastructure, software, and IT support in one unified provider.',
                    'button_text' => 'Try For Free',
                    'features' => json_encode(['14-day free trial', 'No credit card required', 'Free support and migration'])
                ]
            ],
            [
                'name' => 'About Section',
                'type' => 'about-3',
                'order_index' => 2,
                'content' => [
                    'title' => 'Deliver unforgettable customer experiences',
                    'subtitle' => 'Why Nova Agency?',
                    'description' => 'We provide top-notch technology solutions to help your business thrive in the digital age with comprehensive support and robust infrastructure.',
                    'features' => json_encode([
                        ['title' => 'Comprehensive IT Services', 'description' => 'Streamline your operations with our enterprise-grade IT solutions.'],
                        ['title' => 'Affordable', 'description' => 'Make the most of Nova Agency tailored pricing plans.'],
                        ['title' => 'Next-Generation', 'description' => 'Modernize your infrastructure for the future.']
                    ])
                ]
            ],
            [
                'name' => 'Services Section',
                'type' => 'services-list',
                'order_index' => 3,
                'content' => [
                    'title' => 'What We Offer',
                    'subtitle' => 'our services'
                ]
            ],
            [
                'name' => 'Projects Section',
                'type' => 'projects-list',
                'order_index' => 4,
                'content' => [
                    'title' => 'Recent Work',
                    'subtitle' => 'our projects'
                ]
            ],
            [
                'name' => 'Reviews Section',
                'type' => 'reviews-list',
                'order_index' => 5,
                'content' => [
                    'title' => 'What our clients say',
                    'subtitle' => 'client reviews'
                ]
            ],
            [
                'name' => 'Blog Section',
                'type' => 'blog-list',
                'order_index' => 6,
                'content' => [
                    'title' => 'Latest News',
                    'subtitle' => 'our blog'
                ]
            ],
            [
                'name' => 'Contact CTA',
                'type' => 'cta-simple',
                'order_index' => 7,
                'content' => [
                    'title' => 'Tell us about your project',
                    'subtitle' => 'request a quote',
                    'description' => 'Ready to start? Contact us and well get back to you quickly.',
                    'button_text' => 'Go to Contact Page',
                    'button_link' => 'contact'
                ]
            ]
        ];

        // 4. Seed Sections and Content Blocks
        foreach ($sections as $data) {
            $content = $data['content'];
            unset($data['content']);

            $section = $homePage->sections()->create($data);

            foreach ($content as $key => $value) {
                $section->contentBlocks()->create([
                    'key' => $key,
                    'content' => $value,
                    'type' => 'text'
                ]);
            }
        }
    }
}
