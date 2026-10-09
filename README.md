# ELMA Core CMS

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=flat&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=flat&logo=tailwind-css&logoColor=white)

A powerful, modern, and fully responsive Content Management System (CMS) tailored for Digital Agencies and IT Service providers. Built on **Laravel 12**, it features a beautiful **Tailwind CSS** frontend and a comprehensive Admin Panel for dynamic content control.

## 📸 Public Website Preview

| Home | About Us | Contact |
| :---: | :---: | :---: |
| ![Home](docs/images/public_home_png_1774612645127.png) | ![About](docs/images/public_about_1774610627897.png) | ![Contact](docs/images/public_contact_png_1774612704989.png) |

| Services | Projects | Blog |
| :---: | :---: | :---: |
| ![Services](docs/images/public_services_png_1774612663243.png) | ![Projects](docs/images/public_projects_png_1774612674603.png) | ![Blog](docs/images/public_blog_png_1774612693780.png) |

## 🛠️ Admin Backoffice (Full Control)

The backoffice provides modular control over every aspect of the agency's online presence.

### Dashboard & Analytics
| Dashboard | Content & Settings |
| :---: | :---: |
| ![Dashboard](docs/images/admin_dashboard_png_1774612741554.png) | ![Settings](docs/images/admin_settings_png_1774612937758.png) |

### Module Management
| Services | Projects | Blogs |
| :---: | :---: | :---: |
| ![Services](docs/images/admin_services_png_1774612762699.png) | ![Projects](docs/images/admin_projects_png_1774612785108.png) | ![Blogs](docs/images/admin_blogs_png_1774612800255.png) |

| Sliders | Reviews | Users |
| :---: | :---: | :---: |
| ![Sliders](docs/images/admin_sliders_png_1774612828105.png) | ![Reviews](docs/images/admin_reviews_png_1774612811481.png) | ![Users](docs/images/admin_users_png_1774612911364.png) |

### Lead Management
| Contact Messages | Service Requests |
| :---: | :---: |
| ![Contacts](docs/images/admin_contacts_png_1774612837146.png) | ![Requests](docs/images/admin_tc_requests_png_1774612900181.png) |

---

## 👥 User Roles & Use Cases

### 1. **Administrator**
- **Role**: Full system architect and controller.
- **Access**: Complete access to all `/admin` modules.
- **Use Cases**:
  - Manage all website content (Services, Projects, Blogs, Sliders).
  - Manage application users, roles, and system security.
  - Configure global site settings and metadata.
  - Review and analyze Contact and Technical (TC) requests.

### 2. **Content Editor**
- **Role**: Marketing and content focus.
- **Access**: Access to dynamic content modules (Services, Blogs, Projects).
- **Use Cases**:
  - Keep the agency blog updated with industry trends.
  - Add new successful projects to the portfolio.
  - Manage client testimonials and homepage sliders.

### 3. **Public Visitor / Client**
- **Role**: End-user.
- **Access**: Public frontend (`/`).
- **Use Cases**:
  - Research agency services and expertise.
  - View "Case Studies" (Projects) with high-quality visual results.
  - Submit service inquiries and request detailed technical quotes.

---

## 🛠️ Key Features

### 📋 Executive Summary

The **Enterprise Service Hub** is a full-featured **corporate website platform** built as a **headless CMS** with a powerful admin dashboard (Laravel) and a modern public-facing website (Next.js). It is designed for businesses that offer professional services and want to showcase their work, generate leads, publish content, and manage client communications — all from a single unified platform.

### 1. 🏠 Public Website (Client-Facing)

#### 1.1 Homepage
| Feature | Description |
|---------|-------------|
| **Hero Slider / Carousel** | A dynamic, full-screen hero banner with multiple slides. Each slide supports a title, subtitle, description, badge text, primary & secondary CTA buttons, background image or video, custom text colors, overlay opacity, and text alignment. Fully translatable. |
| **Services Overview Section** | Showcases your key services in a grid layout with icons, titles, and short descriptions. Links to individual service pages. |
| **About Section** | A "Who We Are" section with title, subtitle, description, image, and feature highlights. Editable from the admin CMS. |
| **Projects Showcase** | Displays featured portfolio/project work with images, categories, and client names. |
| **Client Testimonials** | A testimonials/reviews carousel showing client reviews with ratings (1–5 stars), client name, position, company, photo, and project type. Featured reviews can be highlighted. |
| **Blog Preview** | Shows the latest published blog articles with images, titles, and excerpts to drive content engagement. |
| **Partners / Clients Bar** | A logo strip showcasing partner or client brand logos with optional links. |
| **Call-to-Action (CTA) Section** | A conversion-focused section with title, subtitle, description, and CTA button. Fully editable. |

#### 1.2 Services Pages
| Feature | Description |
|---------|-------------|
| **Services Listing** | A catalog page listing all active services with title, subtitle, icon, and image. |
| **Service Detail Page** | A rich, individual page per service with full description, SEO metadata, and structured data (JSON-LD). |

#### 1.3 Projects / Portfolio Pages
| Feature | Description |
|---------|-------------|
| **Projects Listing** | A filterable portfolio page showing completed projects with category, client, and completion date. |
| **Project Detail Page** | A detailed case study page with full description, client info, category, and images. |

#### 1.4 Blog / News Pages
| Feature | Description |
|---------|-------------|
| **Blog Listing** | A paginated blog index with category filtering, images, excerpts, and publish dates. |
| **Blog Detail Page** | Full article page with rich content, author attribution, publish date, category, and SEO metadata. |
| **Blog Comments** | Visitors can leave comments on blog posts. Supports threaded/nested replies (parent-child comments). Comments go through approval moderation before becoming visible. |

#### 1.5 Contact & Lead Generation
| Feature | Description |
|---------|-------------|
| **Contact Form** | Visitors can submit inquiries with name, email, phone, company, website, subject, and message. Rate-limited for spam protection. |
| **Service Request Form (TC Request)** | A specialized lead-generation form where visitors can request a specific service, describe their needs, specify budget range & timeline, and attach files. |
| **Newsletter Subscription** | An email subscription form allowing visitors to sign up for updates. Supports subscribe/unsubscribe status management. |

#### 1.6 AI-Powered Chatbot
| Feature | Description |
|---------|-------------|
| **Live AI Chat Widget** | A floating chat widget that lets visitors have real-time AI conversations. The chatbot uses **RAG (Retrieval Augmented Generation)** to pull real context from your services, projects, and blog content — so it gives accurate, business-specific answers instead of generic responses. Supports session memory (multi-turn conversations) and real-time streaming responses. |

#### 1.7 Search
| Feature | Description |
|---------|-------------|
| **Global Keyword Search** | Visitors can search across all services, projects, and blog articles from a unified search modal. Powered by Meilisearch for instant results. |
| **Semantic / AI Search** | An advanced search mode that understands the *meaning* of a query (not just keyword matching). Uses vector embeddings to find contextually relevant results even if exact keywords don't match. |

#### 1.8 Multi-Language Support
| Feature | Description |
|---------|-------------|
| **3 Languages** | The entire public site supports **English**, **French**, and **Arabic**. |
| **Language Switcher** | Visitors can toggle between languages via a language switcher in the navigation bar. |
| **Translatable Content** | All major content (services, projects, blogs, reviews, sliders, CMS blocks) supports per-field translations. |
| **RTL Support** | Arabic (RTL) layout is supported. |

#### 1.9 Legal & Informational Pages
| Feature | Description |
|---------|-------------|
| **About Page** | A dedicated about page with company information pulled from the CMS. |
| **Privacy Policy Page** | A static privacy policy page. |
| **Terms of Service Page** | A static terms & conditions page. |

### 2. 🛡️ Admin Dashboard (Back-Office)

#### 2.1 Dashboard & Analytics
| Feature | Description |
|---------|-------------|
| **Analytics Dashboard** | A comprehensive overview showing key metrics: total users, services, projects, blogs, reviews, contacts, TC requests, unread messages, pending requests, published blogs, and active services. |
| **Time Range Filtering** | Dashboard data can be filtered by **7 days**, **30 days**, **90 days**, or **1 year**. |
| **Trend Charts** | Interactive line/area charts showing contact submissions, service requests, and blog publications over time. |
| **Distribution Charts** | Visual breakdown of contacts vs. service requests distribution. |
| **Top Performing Blogs** | A list of the most-commented blog posts to identify high-engagement content. |
| **Recent Activity Feeds** | Quick-glance panels for recent contacts, recent TC requests, and recent blog posts. |
| **AI-Powered Insights** | One-click AI analysis that generates: performance predictions, readability scores, content gap analysis, and a suggested content calendar — all based on your actual data. Cached for 24 hours with manual refresh option. |

#### 2.2 Services Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Create, read, update, and delete services. |
| **Rich Content** | Each service has a title, slug, subtitle, full rich-text description, icon, image, ordering, and active/inactive toggle. |
| **Multilingual Editing** | Edit service content in English, French, and Arabic. |
| **SEO Fields** | Custom meta title, meta description, and Open Graph image per service. |
| **Ordering** | Control the display order of services. |
| **Activation Toggle** | Instantly show/hide services on the public site. |

#### 2.3 Projects / Portfolio Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Create, read, update, and delete projects. |
| **Project Details** | Title, slug, description, client name, completion date, category, image, ordering, and activation status. |
| **Multilingual Editing** | Per-field translations for all text content. |
| **SEO Fields** | Meta title, meta description, and OG image. |

#### 2.4 Blog Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Create, edit, publish, and delete blog posts. |
| **Rich Content** | Title, slug, excerpt, full content (rich text), featured image, category, author, and publish date. |
| **Draft / Published Status** | Blogs can be saved as drafts (no publish date) or published (with a publish date). |
| **Inline Editing** | Quick inline updates without opening the full edit form. |
| **Bulk Actions** | Select multiple blog posts and apply batch actions (delete, etc.). |
| **Multilingual** | All blog content supports 3-language translations. |
| **SEO Fields** | Meta title, meta description, and OG image. |
| **Author Attribution** | Each blog is linked to an author (admin user). |

#### 2.5 Comments Moderation
| Feature | Description |
|---------|-------------|
| **Comment Listing** | View all comments submitted on blog posts. |
| **Approval Workflow** | Each comment has a status: pending, approved, or rejected. Admins control which comments appear publicly. |
| **Delete Comments** | Remove inappropriate or spam comments. |

#### 2.6 Reviews / Testimonials Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Create, edit, and delete client testimonials. |
| **Review Details** | Client name, position, company, photo, review text, rating (1–5 stars), project type, featured flag, and display ordering. |
| **Featured Reviews** | Mark specific reviews as "featured" for homepage display priority. |
| **Multilingual** | Client name, position, and review text support translations. |

#### 2.7 Slider / Hero Banner Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Create, edit, and delete homepage slider slides. |
| **Rich Slide Options** | Title, subtitle, description, badge text, primary CTA (button text + URL), secondary CTA (button text + URL), background image, video URL, text alignment, overlay opacity, text theme, and custom title/subtitle/description colors. |
| **Activation Toggle** | Quickly enable/disable individual slides. |
| **Sort Order** | Control slide display sequence. |
| **Multilingual** | All text fields support 3-language translations. |

#### 2.8 Partners Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Add, edit, and remove partner/client logos. |
| **Partner Details** | Partner name, logo image, website URL, active status, and display order. |

#### 2.9 Contact Messages (CRM-Lite)
| Feature | Description |
|---------|-------------|
| **Inbox View** | View all contact form submissions in an inbox-style interface. |
| **Read/Unread Status** | Messages are tracked as read or unread, with timestamps. |
| **Mark as Read/Unread** | Manually toggle read status for individual or all messages. |
| **Direct Email Reply** | Reply to a contact message directly from the admin panel. The reply is sent via email to the visitor, and the message is marked as "replied." |
| **Advanced Filtering** | Filter contacts by search text, read/unread status, and date range. |
| **Bulk Actions** | Select multiple contacts and batch delete, mark read, or mark unread. |
| **CSV Export** | Export all contact messages to a CSV file for external use (CRM import, reporting, etc.). |

#### 2.10 Service Requests (TC Requests) Management
| Feature | Description |
|---------|-------------|
| **Request Inbox** | View all service requests submitted by potential clients. |
| **Status Workflow** | Each request has a pipeline status: **Pending → Reviewed → Contacted → Completed** (or **Spam**). |
| **Inline Status Update** | Change request status via AJAX without page reload. |
| **Admin Notes** | Add internal notes to each request for team communication. |
| **Read/Unread Tracking** | Track which requests have been reviewed. |
| **Budget & Timeline** | View the client's stated budget range and project timeline. |
| **File Attachments** | View files attached by the client with their request. |
| **Advanced Filtering** | Filter by search, status, read/unread, and date range. |
| **Bulk Actions** | Batch delete, mark read, or mark unread. |
| **CSV Export** | Export all service requests to CSV. |

#### 2.11 Newsletter Subscribers Management
| Feature | Description |
|---------|-------------|
| **Subscriber List** | View all newsletter subscribers with their status. |
| **Active / Unsubscribed Status** | Track which subscribers are active vs. unsubscribed. |
| **Toggle Status** | Manually activate or deactivate subscribers. |
| **CSV Export** | Export subscriber list to CSV for email marketing platforms. |
| **Delete** | Remove subscribers from the list. |

#### 2.12 CMS / Content Management
| Feature | Description |
|---------|-------------|
| **Page Sections** | The site uses a CMS architecture with Pages → Sections → Content Blocks. Admins can edit the content of each section (hero, about, CTA, etc.) without touching code. |
| **Reorder Sections** | Drag-and-drop to reorder page sections. |
| **Toggle Section Visibility** | Show or hide entire page sections. |
| **Inline Content Editing** | Edit individual content block values (text, images) within sections. |
| **Image Management** | Upload and delete images associated with content blocks. |
| **Multilingual Content Blocks** | All content blocks support per-language translations. |

#### 2.13 Media Library
| Feature | Description |
|---------|-------------|
| **Centralized Upload** | Upload media files (images, etc.) to a central library. Uses **Cloudinary** for cloud-hosted image storage and CDN delivery. |
| **Image Metadata** | Each media item stores file name, MIME type, size, URL, and alt text (for accessibility/SEO). |
| **Delete Media** | Remove media files from the library. |

#### 2.14 User Management
| Feature | Description |
|---------|-------------|
| **Full CRUD** | Create, view, edit, and delete admin users. |
| **Role System** | Two roles: **Admin** (full access) and **Editor** (content management access). |
| **Activate/Deactivate Users** | Toggle user accounts active or inactive. |
| **Profile Image** | Each user can have a profile photo. |

#### 2.15 Settings & Account
| Feature | Description |
|---------|-------------|
| **Profile Management** | Admins can update their name, email, and profile image. |
| **Password Change** | Secure password update with current password verification. |
| **Two-Factor Authentication (2FA)** | Full 2FA setup and management for enhanced account security. Uses TOTP (Time-based One-Time Password). |
| **Theme Preference** | Switch between **Light**, **Dark**, or **System** theme for the admin dashboard. |
| **User Preferences** | Save personalized preferences (e.g., saved filter views) per admin user. |

#### 2.16 Trash / Soft Deletes
| Feature | Description |
|---------|-------------|
| **Unified Trash Bin** | A central trash page showing all soft-deleted items across all content types (services, projects, blogs, reviews, contacts, TC requests, sliders, comments). |
| **Restore** | Recover any accidentally deleted item with one click. |
| **Permanent Delete** | Force-delete items permanently when they are no longer needed. |

#### 2.17 Activity Logs
| Feature | Description |
|---------|-------------|
| **Audit Trail** | Every create, update, and delete action across all content types is automatically logged. |
| **Activity Log Viewer** | Browse all logged activities with details on who performed each action and when. |
| **CSV Export** | Export the activity log to CSV for compliance and record-keeping. |

#### 2.18 Notifications System
| Feature | Description |
|---------|-------------|
| **Real-Time Notifications** | Admins receive in-app notifications for new contacts, new TC requests, and other important events. |
| **Mark as Read** | Dismiss individual notifications or mark all as read in bulk. |
| **Notification Types** | Admin alerts, new contact notifications, and new TC request notifications. |

#### 2.19 Admin Global Search
| Feature | Description |
|---------|-------------|
| **Quick Search** | A search bar across the admin panel that lets admins quickly find services, projects, blogs, contacts, and other content. |

### 3. 🤖 AI-Powered Features

| Feature | Description |
|---------|-------------|
| **AI Content Generation** | Generate blog posts, service descriptions, or any content using AI. Supports configurable **tone** (professional, casual, etc.), **length** (short, medium, long), and **language** (English, French, Arabic). Uses real-time **streaming** for immediate feedback. |
| **AI SEO Analyzer** | Analyze any content and auto-generate: meta title, meta description, OG title/description, focus keywords, SEO score (0–100), readability score (0–100), and actionable improvement suggestions. |
| **AI Admin Assistant** | A conversational assistant that understands natural language commands and can either navigate you to the right admin page or provide helpful answers. |
| **AI Dashboard Insights** | AI-generated business intelligence: performance predictions, content gap analysis, readability assessments, and a suggested editorial calendar. |
| **RAG-Powered Chatbot** | The public-facing chatbot uses Retrieval-Augmented Generation to provide answers grounded in your actual business data (services, projects, blogs). |
| **Semantic Search Embeddings** | All services, projects, and blogs are automatically indexed with AI vector embeddings to power meaning-based search. |

### 4. 🔎 SEO & Discoverability

| Feature | Description |
|---------|-------------|
| **XML Sitemap** | Auto-generated sitemap.xml listing all active blogs, services, and projects for search engine crawlers. |
| **JSON-LD Structured Data** | Rich structured data schemas: Organization, WebSite (with SearchAction), Article (for blogs), Service (for services), BreadcrumbList, and ItemList. |
| **Per-Page SEO Fields** | Every content type (service, project, blog) has dedicated meta title, meta description, and Open Graph image fields. |
| **Clean URL Slugs** | All content uses SEO-friendly slug-based URLs. |
| **HTTP Cache Headers** | Public API routes include `Cache-Control`, `max-age`, and `ETag` headers for optimal browser and CDN caching. |

### 5. 🌐 Multi-Language & Localization

| Feature | Description |
|---------|-------------|
| **3 Supported Languages** | English (en), French (fr), Arabic (ar). |
| **Full UI Localization** | Both the admin dashboard and public website are fully translated. |
| **Per-Field Translations** | Content fields store translations per language using JSONB, allowing simultaneous editing of all language versions. |
| **Locale-Aware API** | The API respects the requested locale and returns content in the appropriate language. |
| **URL-Based Language Switching** | The frontend supports locale-based URL routing (`/en/`, `/fr/`, `/ar/`). |

### 6. 📧 Email Features

| Feature | Description |
|---------|-------------|
| **Contact Reply Emails** | Admins can reply to contact messages; replies are sent as branded emails. |
| **New Contact Notification** | Admins are automatically notified when a new contact message is submitted. |
| **New TC Request Notification** | Admins are automatically notified when a new service request arrives. |
| **Email Verification** | New admin users must verify their email address. |
| **Password Reset** | Full forgot-password → reset-via-email flow. |

### 7. 🔐 Security Features

| Feature | Description |
|---------|-------------|
| **Authentication** | Full login/logout system with session management. Registration is disabled (admin-only access). |
| **Two-Factor Auth (2FA)** | TOTP-based two-factor authentication for admin accounts. |
| **Email Verification** | Admin users must verify their email addresses. |
| **Role-Based Access Control** | Admin vs. Editor roles with authorization policies on all actions. |
| **Rate Limiting** | Public forms (contact, TC request, subscribe, comments) are rate-limited to prevent spam/abuse. |
| **CSRF Protection** | All form submissions are protected against cross-site request forgery. |
| **Input Sanitization** | Content is purified to prevent XSS and injection attacks. |
| **Soft Deletes** | Data is never permanently lost on first delete — it goes to trash first. |

### 8. 📊 Data Export & Reporting

| Feature | Description |
|---------|-------------|
| **Contacts CSV Export** | Export all contact messages with ID, name, email, phone, subject, message, status, and date. |
| **TC Requests CSV Export** | Export all service requests with service name, description, status, read status, attachment indicator, and date. |
| **Subscribers CSV Export** | Export the newsletter subscriber list. |
| **Activity Logs CSV Export** | Export the complete audit trail. |

### 9. 🖥️ Public Website (Next.js Frontend)

#### Pages
| Page | Description |
|------|-------------|
| **Home** | Full landing page with hero slider, services, about, projects, testimonials, blog preview, partners, and CTA sections. |
| **About** | Company information page. |
| **Services** | Services listing and individual service detail pages. |
| **Projects** | Portfolio listing and individual project detail pages. |
| **Blog** | Blog listing and individual article pages with comments. |
| **Contact** | Contact form and service request form. |
| **Privacy Policy** | Privacy policy page. |
| **Terms of Service** | Terms and conditions page. |

#### UI/UX Features
| Feature | Description |
|---------|-------------|
| **Animated Counters** | Numbers that animate/count up when scrolled into view. |
| **Breadcrumb Navigation** | Contextual breadcrumbs on all inner pages with JSON-LD markup. |
| **Magnetic Buttons** | Buttons with magnetic hover effects for modern interactivity. |
| **Tilt Cards** | Cards with 3D tilt effects on hover. |
| **Page Transitions** | Smooth animated transitions between pages. |
| **Chat Widget** | Floating AI chatbot widget accessible from any page. |
| **Search Modal** | A full-screen search overlay with instant results. |
| **Language Switcher** | Seamless language switching in the navigation bar. |
| **Error & 404 States** | Custom-designed error and not-found pages. |
| **Loading States** | Skeleton loading screens for better perceived performance. |
| **PWA / Service Worker** | The frontend includes a service worker and web manifest for potential Progressive Web App capabilities. |
| **Responsive Design** | Fully responsive across desktop, tablet, and mobile devices. |
| **Accessibility (a11y)** | Live announcer component for screen reader support. |

### 10. 📦 Architecture & Infrastructure Summary

| Capability | Details |
|------------|---------|
| **Headless CMS** | Laravel backend serves data via a RESTful API (v1) consumed by the Next.js frontend. |
| **API Health Check** | A `/api/health` endpoint monitors database and cache connectivity. |
| **Caching** | Multi-layer caching: API response caching (30 min), dashboard data caching (5 min), AI insights caching (24 hr), and search embedding caching (1 hr). |
| **Cloud Image Storage** | All images are stored and served via **Cloudinary CDN**. |
| **Full-Text Search** | Powered by **Meilisearch** with indexing on services, projects, and blogs. |
| **Docker Support** | Development and production Docker Compose configurations included. |
| **Soft Deletes** | All major content types support soft deletes with a centralized trash. |
| **Activity Logging** | Automatic audit trail on all content modifications. |

### 📊 Feature Count Summary

| Category | Count |
|----------|-------|
| Public Website Pages | 8 page types |
| Admin Modules | 18 management sections |
| AI Features | 6 AI capabilities |
| Supported Languages | 3 (EN, FR, AR) |
| Content Types | 10 (Services, Projects, Blogs, Reviews, Sliders, Partners, Contacts, TC Requests, Subscribers, Comments) |
| Data Export Options | 4 (Contacts, TC Requests, Subscribers, Activity Logs) |
| Email Notifications | 3 types |
| SEO Features | 5 categories |
| Security Features | 8 mechanisms |

> [!TIP]
> This platform is essentially a **complete digital business hub** — combining a corporate website, CMS, CRM (contact & lead management), blog, portfolio, AI assistant, and analytics dashboard into a single, multilingual, SEO-optimized system.

---

## 🚀 Installation & Local Setup

### System Requirements
- PHP 8.3+
- Node.js & NPM
- SQLite (recommended for local preview) or MySQL

### Steps

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd Enterprise-Service-Hub-Laravel
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
   *Note: Set `DB_CONNECTION=sqlite` in `.env` for quick local testing.*

4. **Database Setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Create Admin User**
   If you didn't use the seeders, or want to create a new admin, run:
   ```bash
   php artisan make:admin
   ```
   Follow the interactive prompts to create your first Administrator account.

6. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Run Locally**
   ```bash
   npm run dev
   php artisan serve
   ```

---

## 📄 License

The framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
