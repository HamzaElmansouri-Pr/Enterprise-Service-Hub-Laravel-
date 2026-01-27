<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pages Table - The Skeleton of the Site
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // e.g., 'home', 'about-us'
            
            // SEO Meta Data
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->boolean('is_home')->default(false); // Quick lookup for homepage
            
            $table->timestamps();
        });

        // 2. Sections Table - Structural Blocks of a Page
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            
            $table->string('name'); // e.g., 'Hero Section', 'Testimonials'
            $table->string('type'); // e.g., 'hero_v3', 'services_grid' (Maps to Blade Component)
            
            $table->integer('order_index')->default(0); # For sorting on the page
            $table->boolean('is_active')->default(true);
            
            // Optional: for section-specific settings (bg-color, padding)
            $table->json('settings')->nullable(); 
            
            $table->timestamps();
        });

        // 3. Content Blocks - The Actual Data (Polymorphic-ish)
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained()->cascadeOnDelete();
            
            $table->string('key'); // e.g., 'title', 'subtitle', 'button_text', 'bg_image'
            
            // We use 'longText' to store everything.
            // For images, we store the path. 
            // For rich text, we store HTML.
            $table->longText('content')->nullable(); 
            
            $table->string('type')->default('text'); // text, image, rich_text, link
            
            $table->timestamps();
            
            // Index for fast lookups
            $table->index(['section_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('pages');
    }
};
