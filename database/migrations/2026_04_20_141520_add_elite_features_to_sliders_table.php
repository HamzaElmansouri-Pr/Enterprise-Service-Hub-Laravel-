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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('badge_text')->nullable()->after('title');
            $table->string('secondary_button_text')->nullable()->after('button_url');
            $table->string('secondary_button_url')->nullable()->after('secondary_button_text');
            $table->string('alignment')->default('left')->after('image');
            $table->string('overlay_opacity')->default('medium')->after('alignment');
            $table->string('text_theme')->default('light')->after('overlay_opacity');
            $table->string('video_url')->nullable()->after('text_theme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn([
                'badge_text',
                'secondary_button_text',
                'secondary_button_url',
                'alignment',
                'overlay_opacity',
                'text_theme',
                'video_url'
            ]);
        });
    }
};
