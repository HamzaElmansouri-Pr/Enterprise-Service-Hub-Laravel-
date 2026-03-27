<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

class CustomTestDataSeeder extends Seeder
{
    public function run(): void
    {
        Service::truncate();
        Project::truncate();
        Blog::truncate();

        $images = [
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.31 (1).jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.31.jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.32 (1).jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.32 (2).jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.32 (3).jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.32 (4).jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.32 (5).jpeg',
            'assets/img/seeded/WhatsApp Image 2025-12-29 at 12.49.32 (6).jpeg',
            'assets/img/seeded/chess-pieces-3840x2160-16662.png',
            'assets/img/seeded/chess-pieces-black-5120x2880-16661.png',
        ];

        $user = User::first() ?? User::factory()->create();

        // Seed Services
        for ($i = 0; $i < 10; $i++) {
            $title = "Premium Service " . ($i + 1);
            Service::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'subtitle' => 'High-quality business solutions',
                'description' => 'Comprehensive and professional service tailored for your business needs.',
                'image' => $images[$i % count($images)],
                'icon' => 'fas fa-rocket',
                'is_active' => true,
                'order_index' => $i + 10, // Higher index to show after initial seeds
            ]);
        }

        // Seed Projects
        for ($i = 0; $i < 10; $i++) {
            $title = "Success Project " . ($i + 1);
            Project::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'description' => 'A successful implementation of advanced technologies.',
                'client' => 'Client ' . ($i + 1),
                'completion_date' => now()->subMonths($i)->toDateString(),
                'category' => ['Modern Web', 'Cloud App', 'AI Solution'][$i % 3],
                'image' => $images[($i + 3) % count($images)],
                'is_active' => true,
                'order_index' => $i + 10,
            ]);
        }

        // Seed Blogs
        for ($i = 0; $i < 10; $i++) {
            $title = "Industry Insight " . ($i + 1);
            Blog::create([
                'title' => $title,
                'slug' => Str::slug($title) . '-' . uniqid(),
                'content' => 'Full detailed content about the latest industry trends and insights.',
                'excerpt' => 'A brief summary of the industry insight.',
                'image' => $images[($i + 6) % count($images)],
                'author_id' => $user->id,
                'published_at' => now()->subDays($i),
                'is_active' => true,
                'category' => 'Technology',
            ]);
        }
    }
}
