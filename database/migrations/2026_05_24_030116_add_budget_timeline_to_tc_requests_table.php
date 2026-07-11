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
        Schema::table('tc_requests', function (Blueprint $table) {
            $table->string('budget_range')->nullable()->after('description');
            $table->string('timeline')->nullable()->after('budget_range');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tc_requests', function (Blueprint $table) {
            $table->dropColumn(['budget_range', 'timeline']);
        });
    }
};
