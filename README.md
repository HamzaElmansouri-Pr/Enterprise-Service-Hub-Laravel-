# Nova Agency CMS

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=flat&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=flat&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/alpinejs-%238BC0D0.svg?style=flat&logo=alpine.js&logoColor=white)

A powerful, modern, and fully responsive Content Management System (CMS) designed tailored for Digital Agencies and IT Service providers. Built on **Laravel 11**, it features a beautiful **Tailwind CSS** frontend and a comprehensive Admin Panel for dynamic content control.

## 🚀 Key Features

### 🎨 Modern Frontend
- **Responsive Design**: Fully optimized for Mobile, Tablet, and Desktop (Mobile-first approach).
- **Dynamic Hero Slider**: Touch-enabled, interactive sliders with glassmorphism UI.
- **Tech Stack**: Blade Templates + Tailwind CSS + Alpine.js.
- **SEO Optimized**: dynamic meta tags and semantic HTML structure.

### 🛠️ Admin Dashboard
- **Content Management**:
  - **Dynamic Sliders**: Create, edit, and reorder homepage sliders with live previews.
  - **Service Catalog**: Manage service listings with icons and detailed descriptions.
  - **Portfolio/Projects**: Showcase case studies with image galleries.
  - **Testimonials**: Manage client reviews and trust signals.
- **Media Management**: Secure file uploading with validation (optimized for server limits).
- **Security**: Robust authentication and validation rules.

## 🛠️ Technology Stack

- **Backend**: PHP 8.2+, Laravel 11
- **Frontend**: Tailwind CSS 3.4, Alpine.js 3.x
- **Database**: MySQL
- **Build Tools**: Vite

## 📦 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/nova-agency-cms.git
   cd nova-agency-cms
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   - Configure your database credentials in `.env`
   - Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Run Locally**
   ```bash
   npm run dev
   php artisan serve
   ```

## 🔒 Security

If you discover any security related issues, please create an issue in the repository.

## 📄 License

The framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


