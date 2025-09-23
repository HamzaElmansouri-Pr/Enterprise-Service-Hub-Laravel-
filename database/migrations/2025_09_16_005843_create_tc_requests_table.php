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
            $table->text('description');
            $table->string('attached_file')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed, rejected
            $table->text('admin_notes')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
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