<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        foreach (['title', 'meta_title', 'meta_description'] as $column) {
            DB::statement("ALTER TABLE pages ALTER COLUMN {$column} TYPE jsonb USING CASE WHEN {$column} IS NULL THEN NULL ELSE json_build_object('en', {$column}) END;");
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE pages ALTER COLUMN title TYPE varchar USING title->>'en';");
        DB::statement("ALTER TABLE pages ALTER COLUMN meta_title TYPE varchar USING meta_title->>'en';");
        DB::statement("ALTER TABLE pages ALTER COLUMN meta_description TYPE text USING meta_description->>'en';");
    }
};
