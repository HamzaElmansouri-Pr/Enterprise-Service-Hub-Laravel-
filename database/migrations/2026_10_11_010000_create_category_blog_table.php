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
        Schema::create('category_blog', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('blog_id')->constrained('blogs')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['category_id', 'blog_id']);
        });

        // Migrate existing distinct categories from blogs table
        try {
            $blogs = DB::table('blogs')->whereNotNull('category')->where('category', '!=', '')->get();
            $maxOrder = (int) (DB::table('categories')->max('order_index') ?? 0);
            $order = $maxOrder + 1;

            foreach ($blogs as $blog) {
                $catName = trim((string) $blog->category);
                if ($catName === '') {
                    continue;
                }

                $slug = Str::slug($catName);
                if ($slug === '') {
                    $slug = 'category-' . ($order++);
                }

                $existingCat = DB::table('categories')->where('slug', $slug)->first();
                if ($existingCat) {
                    $categoryId = $existingCat->id;
                } else {
                    $categoryId = DB::table('categories')->insertGetId([
                        'name' => json_encode(['en' => $catName, 'ar' => $catName, 'fr' => $catName]),
                        'slug' => $slug,
                        'is_active' => true,
                        'order_index' => $order++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('category_blog')->insertOrIgnore([
                    'category_id' => $categoryId,
                    'blog_id' => $blog->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            // Silently continue if blogs table is empty or error occurs
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_blog');
    }
};
