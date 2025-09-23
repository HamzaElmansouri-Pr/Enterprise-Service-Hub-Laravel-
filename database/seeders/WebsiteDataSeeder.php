<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\TcRequest;

class WebsiteDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Pages
        $this->createPages();
        
        // Create Services
        $this->createServices();
        
        // Create Projects
        $this->createProjects();
        
        // Create Blogs
        $this->createBlogs();
        
        // Create Reviews
        $this->createReviews();
        
        // Create Sliders
        $this->createSliders();
        
        // Create Sample Contacts
        $this->createContacts();
        
        // Create Sample TC Requests
        $this->createTcRequests();
        
        $this->command->info('Website data seeded successfully!');
    }
    
    private function createPages()
    {
        $pages = [
            [
                'name' => 'home',
                'title' => 'SupremeIT - Complete CRM Solution',
                'subtitle' => 'The complete CRM solution built for your success',
                'description' => 'All your customer data, tools, and insights in one unified platform.',
                'image' => asset('assets/img/home-3/hero/hero-image.png'),
                'content' => 'SupremeIT provides cutting-edge technology solutions to help businesses grow and succeed in the digital world.',
                'meta_data' => [
                    'keywords' => 'CRM, business solutions, technology, SupremeIT',
                    'description' => 'The complete CRM solution built for your success'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'about',
                'title' => 'About SupremeIT',
                'subtitle' => 'Deliver unforgettable customer experiences',
                'description' => 'We are a team of passionate professionals dedicated to helping businesses succeed through innovative technology solutions.',
                'image' => asset('assets/img/new-add/crm-img.png'),
                'content' => 'SupremeIT was founded with a simple mission: to help businesses leverage technology for growth and success. Our team of experts brings years of experience in CRM, automation, and digital transformation.',
                'meta_data' => [
                    'keywords' => 'about SupremeIT, company, team, mission',
                    'description' => 'Learn about SupremeIT and our mission to help businesses succeed'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'services',
                'title' => 'Our Services',
                'subtitle' => 'Comprehensive solutions for your business',
                'description' => 'We offer a wide range of services to help your business grow and succeed in the digital world.',
                'image' => asset('assets/img/service/service-bg.jpg'),
                'content' => 'From CRM implementation to custom software development, we provide end-to-end solutions tailored to your business needs.',
                'meta_data' => [
                    'keywords' => 'services, CRM, software development, business solutions',
                    'description' => 'Comprehensive business solutions and services'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'projects',
                'title' => 'Our Projects',
                'subtitle' => 'Showcasing our successful implementations',
                'description' => 'Explore our portfolio of successful projects and see how we\'ve helped businesses transform their operations.',
                'image' => asset('assets/img/project/project-bg.jpg'),
                'content' => 'Our portfolio showcases a diverse range of successful projects across various industries, demonstrating our expertise and commitment to excellence.',
                'meta_data' => [
                    'keywords' => 'projects, portfolio, case studies, implementations',
                    'description' => 'Explore our successful project implementations'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'blog',
                'title' => 'Our Blog',
                'subtitle' => 'Latest insights and industry news',
                'description' => 'Stay updated with the latest trends, insights, and best practices in technology and business.',
                'image' => asset('assets/img/blog/blog-bg.jpg'),
                'content' => 'Our blog features expert insights, industry trends, and practical tips to help you stay ahead in the digital world.',
                'meta_data' => [
                    'keywords' => 'blog, insights, technology news, business tips',
                    'description' => 'Latest insights and industry news from SupremeIT'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'contact',
                'title' => 'Contact Us',
                'subtitle' => 'Ready to get started?',
                'description' => 'Contact us today to learn more about how SupremeIT can help your business grow.',
                'image' => asset('assets/img/contact/contact-bg.jpg'),
                'content' => 'Get in touch with our team to discuss your project requirements and discover how we can help your business succeed.',
                'meta_data' => [
                    'keywords' => 'contact, get in touch, consultation, support',
                    'description' => 'Contact SupremeIT for business consultation and support'
                ],
                'is_active' => true,
            ],
        ];
        
        foreach ($pages as $page) {
            Page::create($page);
        }
    }
    
    private function createServices()
    {
        $services = [
            [
                'title' => 'CRM Implementation',
                'subtitle' => 'Complete customer relationship management',
                'description' => 'We help you implement and customize CRM systems that streamline your sales, marketing, and customer service processes.',
                'image' => asset('assets/img/service/crm-service.jpg'),
                'icon' => 'fas fa-users-cog',
                'features' => ['Custom CRM setup', 'Data migration', 'User training', 'Ongoing support'],
                'price' => 2999.00,
                'price_unit' => 'project',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Web Development',
                'subtitle' => 'Modern, responsive websites',
                'description' => 'We create stunning, responsive websites that provide excellent user experience and drive business growth.',
                'image' => asset('assets/img/service/web-service.jpg'),
                'icon' => 'fas fa-code',
                'features' => ['Responsive design', 'SEO optimization', 'Fast loading', 'Mobile-friendly'],
                'price' => 1999.00,
                'price_unit' => 'project',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Mobile App Development',
                'subtitle' => 'Native and cross-platform apps',
                'description' => 'We develop mobile applications for iOS and Android that engage users and drive business value.',
                'image' => asset('assets/img/service/mobile-service.jpg'),
                'icon' => 'fas fa-mobile-alt',
                'features' => ['Native development', 'Cross-platform', 'App store optimization', 'Maintenance'],
                'price' => 4999.00,
                'price_unit' => 'project',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Cloud Solutions',
                'subtitle' => 'Scalable cloud infrastructure',
                'description' => 'We help you migrate to the cloud and optimize your infrastructure for better performance and cost efficiency.',
                'image' => asset('assets/img/service/cloud-service.jpg'),
                'icon' => 'fas fa-cloud',
                'features' => ['Cloud migration', 'Infrastructure setup', 'Security implementation', 'Monitoring'],
                'price' => 3999.00,
                'price_unit' => 'project',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Data Analytics',
                'subtitle' => 'Insights from your data',
                'description' => 'Transform your data into actionable insights with our advanced analytics and reporting solutions.',
                'image' => asset('assets/img/service/analytics-service.jpg'),
                'icon' => 'fas fa-chart-line',
                'features' => ['Data visualization', 'Custom reports', 'Predictive analytics', 'Dashboard creation'],
                'price' => 2499.00,
                'price_unit' => 'project',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];
        
        foreach ($services as $service) {
            Service::create($service);
        }
    }
    
    private function createProjects()
    {
        $projects = [
            [
                'title' => 'E-Commerce Platform',
                'subtitle' => 'Complete online shopping solution',
                'description' => 'We developed a comprehensive e-commerce platform with advanced features including inventory management, payment processing, and customer analytics.',
                'image' => asset('assets/img/project/ecommerce-project.jpg'),
                'gallery' => [
                    asset('assets/img/project/ecommerce-1.jpg'),
                    asset('assets/img/project/ecommerce-2.jpg'),
                    asset('assets/img/project/ecommerce-3.jpg'),
                ],
                'client' => 'TechStore Inc.',
                'category' => 'E-Commerce',
                'project_date' => now()->subMonths(2),
                'project_url' => 'https://example-ecommerce.com',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe API', 'AWS'],
                'challenge' => 'The client needed a scalable e-commerce solution that could handle high traffic and complex inventory management.',
                'solution' => 'We built a custom Laravel-based platform with Vue.js frontend, integrated with Stripe for payments and AWS for hosting.',
                'result' => 'The platform now handles 10,000+ daily transactions with 99.9% uptime and increased sales by 150%.',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Healthcare Management System',
                'subtitle' => 'Patient management and scheduling',
                'description' => 'A comprehensive healthcare management system that streamlines patient records, appointment scheduling, and billing processes.',
                'image' => asset('assets/img/project/healthcare-project.jpg'),
                'gallery' => [
                    asset('assets/img/project/healthcare-1.jpg'),
                    asset('assets/img/project/healthcare-2.jpg'),
                ],
                'client' => 'MediCare Clinic',
                'category' => 'Healthcare',
                'project_date' => now()->subMonths(4),
                'project_url' => 'https://example-healthcare.com',
                'technologies' => ['React', 'Node.js', 'MongoDB', 'JWT', 'Docker'],
                'challenge' => 'The clinic needed a secure, HIPAA-compliant system to manage patient data and appointments.',
                'solution' => 'We developed a React-based SPA with Node.js backend, implementing strict security measures and compliance protocols.',
                'result' => 'Reduced appointment scheduling time by 70% and improved patient satisfaction scores significantly.',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Financial Dashboard',
                'subtitle' => 'Real-time financial analytics',
                'description' => 'A comprehensive financial dashboard that provides real-time insights into business performance and financial metrics.',
                'image' => asset('assets/img/project/finance-project.jpg'),
                'gallery' => [
                    asset('assets/img/project/finance-1.jpg'),
                    asset('assets/img/project/finance-2.jpg'),
                ],
                'client' => 'FinanceCorp',
                'category' => 'Finance',
                'project_date' => now()->subMonths(6),
                'project_url' => 'https://example-finance.com',
                'technologies' => ['Angular', 'Python', 'PostgreSQL', 'Chart.js', 'Redis'],
                'challenge' => 'The client needed real-time financial data visualization with complex calculations and reporting.',
                'solution' => 'We built an Angular dashboard with Python backend, implementing real-time data processing and advanced charting.',
                'result' => 'Enabled real-time decision making and reduced reporting time from hours to minutes.',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];
        
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
    
    private function createBlogs()
    {
        $blogs = [
            [
                'title' => 'The Future of CRM: Trends to Watch in 2024',
                'slug' => 'future-crm-trends-2024',
                'excerpt' => 'Discover the latest trends and innovations in CRM technology that will shape the future of customer relationship management.',
                'content' => '<p>Customer Relationship Management (CRM) systems have evolved significantly over the years, and 2024 promises to bring even more exciting developments. In this comprehensive guide, we\'ll explore the key trends that are shaping the future of CRM technology.</p>

<h3>1. Artificial Intelligence Integration</h3>
<p>AI is becoming increasingly integrated into CRM systems, enabling predictive analytics, automated lead scoring, and intelligent customer insights. These AI-powered features help businesses make more informed decisions and improve customer experiences.</p>

<h3>2. Mobile-First Approach</h3>
<p>With the majority of users accessing CRM systems on mobile devices, a mobile-first approach is essential. Modern CRM systems are designed with responsive interfaces and mobile apps that provide full functionality on any device.</p>

<h3>3. Personalization at Scale</h3>
<p>Advanced CRM systems now offer sophisticated personalization capabilities, allowing businesses to deliver tailored experiences to each customer based on their preferences, behavior, and history.</p>

<h3>4. Integration with Emerging Technologies</h3>
<p>CRM systems are increasingly integrating with IoT devices, blockchain technology, and other emerging technologies to provide more comprehensive customer insights and automation capabilities.</p>

<p>As we move forward, businesses that embrace these trends will be better positioned to deliver exceptional customer experiences and drive growth.</p>',
                'featured_image' => asset('assets/img/blog/crm-trends.jpg'),
                'author' => 'John Smith',
                'category' => 'Technology',
                'tags' => ['CRM', 'Technology', 'AI', 'Future Trends'],
                'views' => 1250,
                'likes' => 89,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'How to Choose the Right CRM for Your Business',
                'slug' => 'choose-right-crm-business',
                'excerpt' => 'A comprehensive guide to selecting the perfect CRM system that aligns with your business needs and goals.',
                'content' => '<p>Choosing the right CRM system is crucial for your business success. With so many options available, it can be overwhelming to make the right choice. Here\'s a step-by-step guide to help you select the perfect CRM for your business.</p>

<h3>1. Define Your Requirements</h3>
<p>Start by clearly defining what you need from a CRM system. Consider your business size, industry, and specific requirements such as lead management, sales tracking, or customer support.</p>

<h3>2. Evaluate Features and Functionality</h3>
<p>Look for CRM systems that offer the features you need, such as contact management, sales pipeline tracking, reporting, and integration capabilities.</p>

<h3>3. Consider Scalability</h3>
<p>Choose a CRM that can grow with your business. Consider factors like user limits, data storage, and additional features you might need in the future.</p>

<h3>4. Check Integration Options</h3>
<p>Ensure the CRM can integrate with your existing tools and systems, such as email marketing platforms, accounting software, and other business applications.</p>

<h3>5. Test Before You Buy</h3>
<p>Most CRM providers offer free trials. Take advantage of these to test the system and see if it meets your needs before making a commitment.</p>

<p>By following these steps, you\'ll be able to choose a CRM system that perfectly fits your business requirements and helps you achieve your goals.</p>',
                'featured_image' => asset('assets/img/blog/choose-crm.jpg'),
                'author' => 'Sarah Johnson',
                'category' => 'Business',
                'tags' => ['CRM', 'Business', 'Selection Guide', 'Best Practices'],
                'views' => 980,
                'likes' => 67,
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'The Benefits of Cloud-Based CRM Solutions',
                'slug' => 'benefits-cloud-crm-solutions',
                'excerpt' => 'Explore the advantages of cloud-based CRM systems and why they\'re becoming the preferred choice for businesses of all sizes.',
                'content' => '<p>Cloud-based CRM solutions have revolutionized how businesses manage customer relationships. In this article, we\'ll explore the key benefits of choosing a cloud-based CRM system.</p>

<h3>1. Accessibility and Mobility</h3>
<p>Cloud-based CRM systems can be accessed from anywhere with an internet connection, allowing your team to work remotely and stay connected to customer data.</p>

<h3>2. Cost-Effectiveness</h3>
<p>Cloud CRM solutions typically require lower upfront costs and offer flexible pricing models, making them more affordable for small and medium-sized businesses.</p>

<h3>3. Automatic Updates and Maintenance</h3>
<p>Cloud providers handle system updates and maintenance, ensuring your CRM is always up-to-date with the latest features and security patches.</p>

<h3>4. Scalability</h3>
<p>Cloud-based systems can easily scale up or down based on your business needs, allowing you to add or remove users and features as required.</p>

<h3>5. Enhanced Security</h3>
<p>Cloud providers invest heavily in security measures, often providing better protection than on-premises solutions.</p>

<p>These benefits make cloud-based CRM solutions an excellent choice for businesses looking to modernize their customer relationship management processes.</p>',
                'featured_image' => asset('assets/img/blog/cloud-crm.jpg'),
                'author' => 'Mike Davis',
                'category' => 'Technology',
                'tags' => ['Cloud CRM', 'Technology', 'Benefits', 'Business'],
                'views' => 750,
                'likes' => 45,
                'is_featured' => false,
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
        ];
        
        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
    
    private function createReviews()
    {
        $reviews = [
            [
                'client_name' => 'Jennifer Martinez',
                'client_position' => 'CEO',
                'client_company' => 'TechStart Inc.',
                'client_image' => asset('assets/img/reviews/client-1.jpg'),
                'review_text' => 'SupremeIT transformed our business operations with their CRM implementation. The team was professional, knowledgeable, and delivered exactly what we needed. Highly recommended!',
                'rating' => 5,
                'project_type' => 'CRM Implementation',
                'is_featured' => true,
                'is_approved' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'David Thompson',
                'client_position' => 'Operations Manager',
                'client_company' => 'RetailCorp',
                'client_image' => asset('assets/img/reviews/client-2.jpg'),
                'review_text' => 'The web development team at SupremeIT created an amazing e-commerce platform for us. Sales have increased by 200% since launch. Excellent work!',
                'rating' => 5,
                'project_type' => 'Web Development',
                'is_featured' => true,
                'is_approved' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Lisa Chen',
                'client_position' => 'CTO',
                'client_company' => 'HealthTech Solutions',
                'client_image' => asset('assets/img/reviews/client-3.jpg'),
                'review_text' => 'SupremeIT\'s mobile app development exceeded our expectations. The app is user-friendly, fast, and has received excellent feedback from our users.',
                'rating' => 5,
                'project_type' => 'Mobile App Development',
                'is_featured' => true,
                'is_approved' => true,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'Robert Wilson',
                'client_position' => 'Finance Director',
                'client_company' => 'FinanceFirst',
                'client_image' => asset('assets/img/reviews/client-4.jpg'),
                'review_text' => 'The cloud migration project was executed flawlessly. SupremeIT\'s team ensured zero downtime and improved our system performance significantly.',
                'rating' => 5,
                'project_type' => 'Cloud Solutions',
                'is_featured' => false,
                'is_approved' => true,
                'sort_order' => 4,
            ],
            [
                'client_name' => 'Amanda Rodriguez',
                'client_position' => 'Marketing Director',
                'client_company' => 'MarketingPro',
                'client_image' => asset('assets/img/reviews/client-5.jpg'),
                'review_text' => 'The data analytics dashboard provided by SupremeIT has revolutionized our decision-making process. The insights are invaluable for our business growth.',
                'rating' => 5,
                'project_type' => 'Data Analytics',
                'is_featured' => false,
                'is_approved' => true,
                'sort_order' => 5,
            ],
        ];
        
        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
    
    private function createSliders()
    {
        $sliders = [
            [
                'title' => 'The complete CRM solution built for your success',
                'subtitle' => 'All your customer data, tools, and insights in one unified platform',
                'description' => 'Transform your business with our comprehensive CRM solution that streamlines operations and drives growth.',
                'image' => asset('assets/img/home-3/hero/hero-image.png'),
                'button_text' => 'Get Started',
                'button_url' => route('contact'),
                'button_color' => 'primary',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Boost Your Business with Technology',
                'subtitle' => 'Innovative solutions for modern businesses',
                'description' => 'Discover how our cutting-edge technology solutions can help your business grow and succeed in the digital age.',
                'image' => asset('assets/img/home-3/hero/hero-image-2.png'),
                'button_text' => 'Learn More',
                'button_url' => route('about'),
                'button_color' => 'secondary',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Expert Development Services',
                'subtitle' => 'Custom solutions tailored to your needs',
                'description' => 'Our experienced team delivers high-quality web and mobile applications that drive business success.',
                'image' => asset('assets/img/home-3/hero/hero-image-3.png'),
                'button_text' => 'View Portfolio',
                'button_url' => route('projects'),
                'button_color' => 'success',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];
        
        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
    
    private function createContacts()
    {
        $contacts = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1-555-0123',
                'subject' => 'CRM Consultation',
                'message' => 'I\'m interested in learning more about your CRM solutions for my small business.',
                'company' => 'SmallBiz Inc.',
                'website' => 'https://smallbiz.com',
                'is_read' => true,
                'read_at' => now()->subDays(2),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1-555-0456',
                'subject' => 'Web Development Inquiry',
                'message' => 'We need a new website for our company. Can you provide a quote?',
                'company' => 'TechCorp',
                'website' => 'https://techcorp.com',
                'is_read' => false,
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'phone' => '+1-555-0789',
                'subject' => 'Mobile App Development',
                'message' => 'Looking for a mobile app development partner for our startup.',
                'company' => 'StartupXYZ',
                'is_read' => true,
                'read_at' => now()->subDays(1),
            ],
        ];
        
        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
    
    private function createTcRequests()
    {
        $services = Service::all();
        
        $tcRequests = [
            [
                'email' => 'client1@example.com',
                'description' => 'We need a comprehensive CRM system for our growing business. We have about 50 employees and need features like lead management, sales tracking, and customer support integration.',
                'service_id' => $services->where('title', 'CRM Implementation')->first()->id,
                'status' => 'pending',
                'is_read' => false,
            ],
            [
                'email' => 'client2@example.com',
                'description' => 'Looking for a modern e-commerce website with payment integration and inventory management. We sell electronics and need a scalable solution.',
                'service_id' => $services->where('title', 'Web Development')->first()->id,
                'status' => 'in_progress',
                'admin_notes' => 'Initial consultation scheduled for next week.',
                'is_read' => true,
                'read_at' => now()->subDays(3),
            ],
            [
                'email' => 'client3@example.com',
                'description' => 'We need a mobile app for our restaurant business. Features should include online ordering, table reservations, and customer loyalty program.',
                'service_id' => $services->where('title', 'Mobile App Development')->first()->id,
                'status' => 'completed',
                'admin_notes' => 'Project completed successfully. Client is very satisfied with the results.',
                'is_read' => true,
                'read_at' => now()->subDays(5),
            ],
        ];
        
        foreach ($tcRequests as $tcRequest) {
            TcRequest::create($tcRequest);
        }
    }
}
