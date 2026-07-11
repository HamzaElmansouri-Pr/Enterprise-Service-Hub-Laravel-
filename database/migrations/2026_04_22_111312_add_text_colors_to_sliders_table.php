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
            $table->string('title_color', 7)->nullable()->after('video_url');
            $table->string('subtitle_color', 7)->nullable()->after('title_color');
            $table->string('description_color', 7)->nullable()->after('subtitle_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['title_color', 'subtitle_color', 'description_color']);
        });
    }
};
