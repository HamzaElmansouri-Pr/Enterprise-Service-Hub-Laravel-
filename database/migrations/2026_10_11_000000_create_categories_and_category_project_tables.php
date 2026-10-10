<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('category_project', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['category_id', 'project_id']);
        });

        // Migrate existing distinct categories from projects table
        try {
            $projects = DB::table('projects')->whereNotNull('category')->where('category', '!=', '')->get();
            $categoriesMap = [];
            $order = 0;

            foreach ($projects as $project) {
                $catName = trim((string) $project->category);
                if ($catName === '') {
                    continue;
                }

                $slug = Str::slug($catName);
                if ($slug === '') {
                    $slug = 'category-' . ($order + 1);
                }

                if (!isset($categoriesMap[$slug])) {
                    $categoryId = DB::table('categories')->insertGetId([
                        'name' => json_encode(['en' => $catName, 'ar' => $catName, 'fr' => $catName]),
                        'slug' => $slug,
                        'is_active' => true,
                        'order_index' => $order++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $categoriesMap[$slug] = $categoryId;
                } else {
                    $categoryId = $categoriesMap[$slug];
                }

                DB::table('category_project')->insertOrIgnore([
                    'category_id' => $categoryId,
                    'project_id' => $project->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            // Silently continue if projects table is empty or column not found
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_project');
        Schema::dropIfExists('categories');
    }
};
