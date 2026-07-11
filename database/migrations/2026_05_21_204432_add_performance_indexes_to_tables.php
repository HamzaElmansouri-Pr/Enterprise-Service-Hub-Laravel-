<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add composite indexes for common API queries
        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_active', 'order_index'], 'idx_services_active_order');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index(['is_active', 'order_index'], 'idx_projects_active_order');
            $table->index(['is_active', 'category'], 'idx_projects_active_cat'); // Frequently filtered by category
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['is_active', 'order_index'], 'idx_reviews_active_order');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order'], 'idx_sliders_active_sort');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->index(['is_active', 'order_index'], 'idx_partners_active_order');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->index(['is_active', 'published_at'], 'idx_blogs_active_pub');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->index(['is_read', 'created_at'], 'idx_contacts_read_date');
        });

        Schema::table('tc_requests', function (Blueprint $table) {
            $table->index(['is_read', 'created_at'], 'idx_tcreqs_read_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('idx_services_active_order');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('idx_projects_active_order');
            $table->dropIndex('idx_projects_active_cat');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex('idx_reviews_active_order');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex('idx_sliders_active_sort');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropIndex('idx_partners_active_order');
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex('idx_blogs_active_pub');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex('idx_contacts_read_date');
        });

        Schema::table('tc_requests', function (Blueprint $table) {
            $table->dropIndex('idx_tcreqs_read_date');
        });
    }
};
