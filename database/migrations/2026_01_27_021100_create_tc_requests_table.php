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
        Schema::create('tc_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('attached_file')->nullable();
            
            // Process fields
            $table->string('status')->default('pending'); // pending, processing, completed, rejected
            $table->text('admin_notes')->nullable();
            
            // Admin management fields
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tc_requests');
    }
};
