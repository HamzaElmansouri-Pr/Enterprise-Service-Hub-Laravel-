<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'E-commerce Platform',
                'subtitle' => 'Modern online shopping experience',
                'description' => 'A comprehensive e-commerce platform built with Laravel and Vue.js, featuring advanced product management, secure payment processing, and responsive design.',
                'image' => 'assets/img/project/ecommerce-platform.jpg',
                'gallery' => [
                    'assets/img/project/gallery/ecommerce-1.jpg',
                    'assets/img/project/gallery/ecommerce-2.jpg',
                    'assets/img/project/gallery/ecommerce-3.jpg'
                ],
                'client' => 'TechStore Inc.',
                'category' => 'E-commerce',
                'project_date' => '2024-01-15',
                'project_url' => 'https://techstore.example.com',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe', 'Bootstrap'],
                'challenge' => 'Building a scalable e-commerce platform that could handle high traffic and complex product variations.',
                'solution' => 'Implemented microservices architecture with Redis caching and CDN integration for optimal performance.',
                'result' => 'Increased conversion rate by 40% and reduced page load time by 60%.',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Mobile Banking App',
                'subtitle' => 'Secure financial management on the go',
                'description' => 'A cross-platform mobile banking application with advanced security features, real-time transactions, and intuitive user interface.',
                'image' => 'assets/img/project/mobile-banking.jpg',
                'gallery' => [
                    'assets/img/project/gallery/banking-1.jpg',
                    'assets/img/project/gallery/banking-2.jpg'
                ],
                'client' => 'SecureBank Ltd.',
                'category' => 'Mobile App',
                'project_date' => '2024-02-20',
                'project_url' => 'https://apps.apple.com/securebank',
                'technologies' => ['React Native', 'Node.js', 'PostgreSQL', 'JWT', 'Biometric Auth'],
                'challenge' => 'Ensuring maximum security while maintaining user-friendly experience.',
                'solution' => 'Implemented multi-factor authentication, end-to-end encryption, and biometric login.',
                'result' => 'Achieved 99.9% security rating and 4.8/5 user satisfaction score.',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Corporate Website Redesign',
                'subtitle' => 'Modern, responsive corporate presence',
                'description' => 'Complete redesign of corporate website with focus on user experience, SEO optimization, and modern design principles.',
                'image' => 'assets/img/project/corporate-website.jpg',
                'gallery' => [
                    'assets/img/project/gallery/corporate-1.jpg',
                    'assets/img/project/gallery/corporate-2.jpg',
                    'assets/img/project/gallery/corporate-3.jpg',
                    'assets/img/project/gallery/corporate-4.jpg'
                ],
                'client' => 'GlobalCorp Solutions',
                'category' => 'Web Development',
                'project_date' => '2024-03-10',
                'project_url' => 'https://globalcorp.example.com',
                'technologies' => ['Laravel', 'Tailwind CSS', 'Alpine.js', 'MySQL', 'CloudFlare'],
                'challenge' => 'Creating a website that represents the company\'s global presence while maintaining fast loading times.',
                'solution' => 'Implemented server-side rendering with CDN optimization and multi-language support.',
                'result' => 'Improved SEO ranking by 150% and increased organic traffic by 80%.',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'IoT Dashboard',
                'subtitle' => 'Real-time device monitoring and control',
                'description' => 'An advanced IoT dashboard for monitoring and controlling connected devices with real-time data visualization and alerts.',
                'image' => 'assets/img/project/iot-dashboard.jpg',
                'gallery' => [
                    'assets/img/project/gallery/iot-1.jpg',
                    'assets/img/project/gallery/iot-2.jpg'
                ],
                'client' => 'SmartTech Industries',
                'category' => 'Web Development',
                'project_date' => '2024-04-05',
                'project_url' => 'https://iot.smarttech.example.com',
                'technologies' => ['React', 'Node.js', 'WebSocket', 'MongoDB', 'Chart.js'],
                'challenge' => 'Handling real-time data from thousands of IoT devices simultaneously.',
                'solution' => 'Implemented WebSocket connections with Redis pub/sub for real-time data streaming.',
                'result' => 'Successfully monitors 10,000+ devices with 99.9% uptime.',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Healthcare Management System',
                'subtitle' => 'Comprehensive patient care solution',
                'description' => 'A complete healthcare management system with patient records, appointment scheduling, and telemedicine capabilities.',
                'image' => 'assets/img/project/healthcare-system.jpg',
                'gallery' => [
                    'assets/img/project/gallery/healthcare-1.jpg',
                    'assets/img/project/gallery/healthcare-2.jpg',
                    'assets/img/project/gallery/healthcare-3.jpg'
                ],
                'client' => 'MediCare Hospital',
                'category' => 'Web Development',
                'project_date' => '2024-05-12',
                'project_url' => 'https://medicare.example.com',
                'technologies' => ['Laravel', 'Vue.js', 'PostgreSQL', 'Docker', 'Redis'],
                'challenge' => 'Ensuring HIPAA compliance while providing seamless user experience.',
                'solution' => 'Implemented end-to-end encryption, audit logging, and role-based access control.',
                'result' => 'Reduced patient wait time by 50% and improved data accuracy by 95%.',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Learning Management System',
                'subtitle' => 'Interactive online education platform',
                'description' => 'A feature-rich LMS with video streaming, quizzes, progress tracking, and virtual classroom capabilities.',
                'image' => 'assets/img/project/lms-platform.jpg',
                'gallery' => [
                    'assets/img/project/gallery/lms-1.jpg',
                    'assets/img/project/gallery/lms-2.jpg'
                ],
                'client' => 'EduTech Academy',
                'category' => 'Web Development',
                'project_date' => '2024-06-18',
                'project_url' => 'https://lms.edutech.example.com',
                'technologies' => ['Laravel', 'React', 'WebRTC', 'FFmpeg', 'MySQL'],
                'challenge' => 'Building a scalable platform for video streaming and real-time collaboration.',
                'solution' => 'Implemented adaptive bitrate streaming and WebRTC for real-time communication.',
                'result' => 'Serves 50,000+ students with 99.8% video streaming success rate.',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }
    }
}
