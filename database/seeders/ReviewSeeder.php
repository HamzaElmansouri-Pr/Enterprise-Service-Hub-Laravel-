<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the CSV file
        $csvPath = base_path('test_reviews.csv');

        if (File::exists($csvPath)) {
            $lines = array_map('str_getcsv', file($csvPath));
            $header = array_shift($lines); // Remove header row

            foreach ($lines as $row) {
                // Combine header with row data to create an associative array
                if (count($header) === count($row)) {
                    $data = array_combine($header, $row);

                    Review::create([
                        'client_name' => $data['client_name'],
                        'client_position' => $data['client_position'] ?? null,
                        'client_company' => $data['client_company'] ?? null,
                        'review_text' => $data['review_text'],
                        'rating' => (int) $data['rating'],
                        'project_type' => $data['project_type'] ?? null,
                        'is_featured' => filter_var($data['is_featured'], FILTER_VALIDATE_BOOLEAN),
                        'is_active' => filter_var($data['is_approved'], FILTER_VALIDATE_BOOLEAN),
                        'order_index' => (int) $data['sort_order'],
                    ]);
                }
            }
        } else {
            // Fallback if CSV is missing
            Review::factory(5)->create();
        }
    }
}
