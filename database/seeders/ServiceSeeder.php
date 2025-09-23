<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Web Development',
                'subtitle' => 'Custom websites and web applications',
                'description' => 'We create stunning, responsive websites and web applications tailored to your business needs. Our team uses the latest technologies to deliver high-performance solutions.',
                'icon' => 'fas fa-code',
                'image' => 'assets/img/service/web-development.jpg',
                'features' => [
                    'Responsive Design',
                    'SEO Optimized',
                    'Fast Loading',
                    'Mobile Friendly',
                    'Cross-browser Compatible'
                ],
                'price' => 2500.00,
                'price_unit' => 'per project',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Mobile App Development',
                'subtitle' => 'iOS and Android applications',
                'description' => 'Build powerful mobile applications for iOS and Android platforms. We create user-friendly apps that engage your customers and drive business growth.',
                'icon' => 'fas fa-mobile-alt',
                'image' => 'assets/img/service/mobile-app.jpg',
                'features' => [
                    'Native iOS & Android',
                    'Cross-platform Solutions',
                    'User-friendly Interface',
                    'App Store Optimization',
                    'Regular Updates & Support'
                ],
                'price' => 5000.00,
                'price_unit' => 'per project',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Digital Marketing',
                'subtitle' => 'Grow your online presence',
                'description' => 'Comprehensive digital marketing services to help your business reach more customers and increase sales through strategic online campaigns.',
                'icon' => 'fas fa-chart-line',
                'image' => 'assets/img/service/digital-marketing.jpg',
                'features' => [
                    'SEO Services',
                    'Social Media Marketing',
                    'Google Ads Management',
                    'Content Marketing',
                    'Analytics & Reporting'
                ],
                'price' => 1500.00,
                'price_unit' => 'per month',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'E-commerce Solutions',
                'subtitle' => 'Online stores that convert',
                'description' => 'Complete e-commerce solutions including online store setup, payment integration, inventory management, and order processing systems.',
                'icon' => 'fas fa-shopping-cart',
                'features' => [
                    'Online Store Setup',
                    'Payment Gateway Integration',
                    'Inventory Management',
                    'Order Processing',
                    'Customer Management'
                ],
                'price' => 3500.00,
                'price_unit' => 'per project',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Cloud Solutions',
                'subtitle' => 'Scalable cloud infrastructure',
                'description' => 'Migrate your business to the cloud with our comprehensive cloud solutions. We help you leverage cloud technology for better performance and scalability.',
                'icon' => 'fas fa-cloud',
                'features' => [
                    'Cloud Migration',
                    'AWS/Azure Setup',
                    'Data Backup Solutions',
                    'Security Implementation',
                    '24/7 Monitoring'
                ],
                'price' => 2000.00,
                'price_unit' => 'per month',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'IT Consulting',
                'subtitle' => 'Strategic technology guidance',
                'description' => 'Expert IT consulting services to help you make informed technology decisions and optimize your IT infrastructure for maximum efficiency.',
                'icon' => 'fas fa-lightbulb',
                'features' => [
                    'Technology Assessment',
                    'Strategic Planning',
                    'System Optimization',
                    'Security Audits',
                    'Training & Support'
                ],
                'price' => 150.00,
                'price_unit' => 'per hour',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
