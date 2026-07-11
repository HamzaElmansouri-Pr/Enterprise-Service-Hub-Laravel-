<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip for SQLite - it doesn't support JSONB type or json_build_object
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        // Services
        DB::statement("ALTER TABLE services ALTER COLUMN title TYPE jsonb USING CASE WHEN title IS NULL THEN NULL ELSE json_build_object('en', title) END;");
        DB::statement("ALTER TABLE services ALTER COLUMN subtitle TYPE jsonb USING CASE WHEN subtitle IS NULL THEN NULL ELSE json_build_object('en', subtitle) END;");
        DB::statement("ALTER TABLE services ALTER COLUMN description TYPE jsonb USING CASE WHEN description IS NULL THEN NULL ELSE json_build_object('en', description) END;");
        DB::statement("ALTER TABLE services ALTER COLUMN meta_title TYPE jsonb USING CASE WHEN meta_title IS NULL THEN NULL ELSE json_build_object('en', meta_title) END;");
        DB::statement("ALTER TABLE services ALTER COLUMN meta_description TYPE jsonb USING CASE WHEN meta_description IS NULL THEN NULL ELSE json_build_object('en', meta_description) END;");

        // Projects
        DB::statement("ALTER TABLE projects ALTER COLUMN title TYPE jsonb USING CASE WHEN title IS NULL THEN NULL ELSE json_build_object('en', title) END;");
        DB::statement("ALTER TABLE projects ALTER COLUMN description TYPE jsonb USING CASE WHEN description IS NULL THEN NULL ELSE json_build_object('en', description) END;");
        DB::statement("ALTER TABLE projects ALTER COLUMN meta_title TYPE jsonb USING CASE WHEN meta_title IS NULL THEN NULL ELSE json_build_object('en', meta_title) END;");
        DB::statement("ALTER TABLE projects ALTER COLUMN meta_description TYPE jsonb USING CASE WHEN meta_description IS NULL THEN NULL ELSE json_build_object('en', meta_description) END;");

        // Blogs
        DB::statement("ALTER TABLE blogs ALTER COLUMN title TYPE jsonb USING CASE WHEN title IS NULL THEN NULL ELSE json_build_object('en', title) END;");
        DB::statement("ALTER TABLE blogs ALTER COLUMN excerpt TYPE jsonb USING CASE WHEN excerpt IS NULL THEN NULL ELSE json_build_object('en', excerpt) END;");
        DB::statement("ALTER TABLE blogs ALTER COLUMN content TYPE jsonb USING CASE WHEN content IS NULL THEN NULL ELSE json_build_object('en', content) END;");
        DB::statement("ALTER TABLE blogs ALTER COLUMN meta_title TYPE jsonb USING CASE WHEN meta_title IS NULL THEN NULL ELSE json_build_object('en', meta_title) END;");
        DB::statement("ALTER TABLE blogs ALTER COLUMN meta_description TYPE jsonb USING CASE WHEN meta_description IS NULL THEN NULL ELSE json_build_object('en', meta_description) END;");

        // Sliders
        DB::statement("ALTER TABLE sliders ALTER COLUMN title TYPE jsonb USING CASE WHEN title IS NULL THEN NULL ELSE json_build_object('en', title) END;");
        DB::statement("ALTER TABLE sliders ALTER COLUMN subtitle TYPE jsonb USING CASE WHEN subtitle IS NULL THEN NULL ELSE json_build_object('en', subtitle) END;");
        DB::statement("ALTER TABLE sliders ALTER COLUMN description TYPE jsonb USING CASE WHEN description IS NULL THEN NULL ELSE json_build_object('en', description) END;");
        DB::statement("ALTER TABLE sliders ALTER COLUMN badge_text TYPE jsonb USING CASE WHEN badge_text IS NULL THEN NULL ELSE json_build_object('en', badge_text) END;");
        DB::statement("ALTER TABLE sliders ALTER COLUMN button_text TYPE jsonb USING CASE WHEN button_text IS NULL THEN NULL ELSE json_build_object('en', button_text) END;");
        DB::statement("ALTER TABLE sliders ALTER COLUMN secondary_button_text TYPE jsonb USING CASE WHEN secondary_button_text IS NULL THEN NULL ELSE json_build_object('en', secondary_button_text) END;");

        // Content Blocks
        DB::statement("ALTER TABLE content_blocks ALTER COLUMN content TYPE jsonb USING CASE WHEN content IS NULL THEN NULL ELSE json_build_object('en', content) END;");

        // Reviews
        DB::statement("ALTER TABLE reviews ALTER COLUMN client_name TYPE jsonb USING CASE WHEN client_name IS NULL THEN NULL ELSE json_build_object('en', client_name) END;");
        DB::statement("ALTER TABLE reviews ALTER COLUMN client_position TYPE jsonb USING CASE WHEN client_position IS NULL THEN NULL ELSE json_build_object('en', client_position) END;");
        DB::statement("ALTER TABLE reviews ALTER COLUMN review_text TYPE jsonb USING CASE WHEN review_text IS NULL THEN NULL ELSE json_build_object('en', review_text) END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Skip for SQLite
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        // Reverse operations (converting jsonb back to string by extracting 'en')
        DB::statement("ALTER TABLE services ALTER COLUMN title TYPE varchar USING title->>'en';");
        DB::statement("ALTER TABLE services ALTER COLUMN subtitle TYPE varchar USING subtitle->>'en';");
        DB::statement("ALTER TABLE services ALTER COLUMN description TYPE text USING description->>'en';");
        DB::statement("ALTER TABLE services ALTER COLUMN meta_title TYPE varchar USING meta_title->>'en';");
        DB::statement("ALTER TABLE services ALTER COLUMN meta_description TYPE text USING meta_description->>'en';");

        DB::statement("ALTER TABLE projects ALTER COLUMN title TYPE varchar USING title->>'en';");
        DB::statement("ALTER TABLE projects ALTER COLUMN description TYPE text USING description->>'en';");
        DB::statement("ALTER TABLE projects ALTER COLUMN meta_title TYPE varchar USING meta_title->>'en';");
        DB::statement("ALTER TABLE projects ALTER COLUMN meta_description TYPE text USING meta_description->>'en';");

        DB::statement("ALTER TABLE blogs ALTER COLUMN title TYPE varchar USING title->>'en';");
        DB::statement("ALTER TABLE blogs ALTER COLUMN excerpt TYPE text USING excerpt->>'en';");
        DB::statement("ALTER TABLE blogs ALTER COLUMN content TYPE text USING content->>'en';");
        DB::statement("ALTER TABLE blogs ALTER COLUMN meta_title TYPE varchar USING meta_title->>'en';");
        DB::statement("ALTER TABLE blogs ALTER COLUMN meta_description TYPE text USING meta_description->>'en';");

        DB::statement("ALTER TABLE sliders ALTER COLUMN title TYPE varchar USING title->>'en';");
        DB::statement("ALTER TABLE sliders ALTER COLUMN subtitle TYPE varchar USING subtitle->>'en';");
        DB::statement("ALTER TABLE sliders ALTER COLUMN description TYPE text USING description->>'en';");
        DB::statement("ALTER TABLE sliders ALTER COLUMN badge_text TYPE varchar USING badge_text->>'en';");
        DB::statement("ALTER TABLE sliders ALTER COLUMN button_text TYPE varchar USING button_text->>'en';");
        DB::statement("ALTER TABLE sliders ALTER COLUMN secondary_button_text TYPE varchar USING secondary_button_text->>'en';");

        DB::statement("ALTER TABLE content_blocks ALTER COLUMN content TYPE text USING content->>'en';");

        DB::statement("ALTER TABLE reviews ALTER COLUMN client_name TYPE varchar USING client_name->>'en';");
        DB::statement("ALTER TABLE reviews ALTER COLUMN client_position TYPE varchar USING client_position->>'en';");
        DB::statement("ALTER TABLE reviews ALTER COLUMN review_text TYPE text USING review_text->>'en';");
    }
};
