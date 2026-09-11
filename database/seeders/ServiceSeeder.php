<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'subtitle' => 'Custom websites and web applications',
                'description' => 'We create stunning, responsive websites.',
                'icon' => 'fas fa-code',
                'image' => 'assets/img/case-studies/01.jpg',
                'order_index' => 1,
            ],
            [
                'title' => 'Mobile App Development',
                'subtitle' => 'iOS and Android applications',
                'description' => 'Build powerful mobile applications.',
                'icon' => 'fas fa-mobile-alt',
                'image' => 'assets/img/case-studies/02.jpg',
                'order_index' => 2,
            ],
            [
                'title' => 'UI/UX Design',
                'subtitle' => 'User-centered design solutions',
                'description' => 'Create intuitive and engaging user experiences.',
                'icon' => 'fas fa-paint-brush',
                'image' => 'assets/img/case-studies/03.jpg',
                'order_index' => 3,
            ],
            [
                'title' => 'Digital Marketing',
                'subtitle' => 'Grow your online presence',
                'description' => 'Reach your target audience effectively.',
                'icon' => 'fas fa-bullhorn',
                'image' => 'assets/img/case-studies/04.jpg',
                'order_index' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                array_merge($service, ['is_active' => true])
            );
        }
    }
}
