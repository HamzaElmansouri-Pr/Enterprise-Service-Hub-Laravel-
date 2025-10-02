<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_company', 'like', "%{$search}%")
                  ->orWhere('client_position', 'like', "%{$search}%")
                  ->orWhere('review_text', 'like', "%{$search}%")
                  ->orWhere('project_type', 'like', "%{$search}%");
            });
        }
        
        // Filter by approval status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        
        // Filter by featured status
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }
        
        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        $reviews = $query->latest()->paginate(15);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'project_type' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('client_image')) {
            $image = $request->file('client_image');
            $imageName = time() . '_' . Str::slug($validated['client_name']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $reviewDir = public_path('assets/img/reviews');
            if (!file_exists($reviewDir)) {
                mkdir($reviewDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($reviewDir, $imageName);
            $validated['client_image'] = 'assets/img/reviews/' . $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_approved'] = $request->has('is_approved');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Review::create($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'project_type' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('client_image')) {
            // Delete old image if exists
            if ($review->client_image && file_exists(public_path($review->client_image))) {
                unlink(public_path($review->client_image));
            }

            $image = $request->file('client_image');
            $imageName = time() . '_' . Str::slug($validated['client_name']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $reviewDir = public_path('assets/img/reviews');
            if (!file_exists($reviewDir)) {
                mkdir($reviewDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($reviewDir, $imageName);
            $validated['client_image'] = 'assets/img/reviews/' . $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_approved'] = $request->has('is_approved');
        $validated['sort_order'] = $validated['sort_order'] ?? $review->sort_order ?? 0;

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Delete image if exists
        if ($review->client_image && file_exists(public_path($review->client_image))) {
            unlink(public_path($review->client_image));
        }

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    public function toggleApproved(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);
        
        $status = $review->is_approved ? 'approved' : 'unapproved';
        return redirect()->back()->with('success', "Review {$status} successfully.");
    }

    public function toggleFeatured(Review $review)
    {
        $review->update(['is_featured' => !$review->is_featured]);
        
        $status = $review->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Review {$status} successfully.");
    }
    
    public function export(Request $request)
    {
        $query = Review::query();
        
        // Apply same filters as index page
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_company', 'like', "%{$search}%")
                  ->orWhere('client_position', 'like', "%{$search}%")
                  ->orWhere('review_text', 'like', "%{$search}%")
                  ->orWhere('project_type', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }
        
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }
        
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }
        
        $reviews = $query->ordered()->get();
        
        $filename = 'reviews_' . date('Y-m-d_H-i-s') . '.xlsx';
        $filePath = storage_path('app/' . $filename);
        
        // Create Excel file
        $writer = SimpleExcelWriter::create($filePath)
            ->addHeader([
                'ID',
                'Client Name',
                'Client Position',
                'Client Company', 
                'Review Text',
                'Rating',
                'Project Type',
                'Is Featured',
                'Is Approved',
                'Sort Order',
                'Created At',
                'Updated At'
            ]);
            
        foreach ($reviews as $review) {
            $writer->addRow([
                'ID' => $review->id,
                'Client Name' => $review->client_name,
                'Client Position' => $review->client_position,
                'Client Company' => $review->client_company,
                'Review Text' => $review->review_text,
                'Rating' => $review->rating,
                'Project Type' => $review->project_type,
                'Is Featured' => $review->is_featured ? 'Yes' : 'No',
                'Is Approved' => $review->is_approved ? 'Yes' : 'No',
                'Sort Order' => $review->sort_order,
                'Created At' => $review->created_at->format('Y-m-d H:i:s'),
                'Updated At' => $review->updated_at->format('Y-m-d H:i:s'),
            ]);
        }
        
        $writer->close();
        
        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }
    
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);
        
        $reviews = Review::whereIn('id', $request->review_ids)->get();
        
        foreach ($reviews as $review) {
            // Delete image if exists
            if ($review->client_image && file_exists(public_path($review->client_image))) {
                unlink(public_path($review->client_image));
            }
        }
        
        Review::whereIn('id', $request->review_ids)->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', count($request->review_ids) . ' reviews deleted successfully.');
    }
    
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);
        
        Review::whereIn('id', $request->review_ids)->update(['is_approved' => true]);
        
        return redirect()->route('admin.reviews.index')
            ->with('success', count($request->review_ids) . ' reviews approved successfully.');
    }
    
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max
        ]);

        try {
            $initialCount = Review::count();
            $file = $request->file('import_file');
            
            // Get file extension and create a temporary file with proper extension
            $extension = $file->getClientOriginalExtension();
            $tempPath = storage_path('app/temp_import_' . time() . '.' . $extension);
            
            // Move uploaded file to temp location with proper extension
            $file->move(dirname($tempPath), basename($tempPath));
            
            // Read the uploaded file
            $rows = SimpleExcelReader::create($tempPath)->getRows();
            
            $importedCount = 0;
            $errors = [];
            $lineNumber = 1; // Start from 1 (header row)
            
            foreach ($rows as $row) {
                $lineNumber++;
                
                try {
                    // Skip empty rows
                    if (empty($row['client_name']) || empty($row['review_text'])) {
                        continue;
                    }
                    
                    // Validate and clean data
                    $reviewData = [
                        'client_name' => trim($row['client_name'] ?? ''),
                        'client_position' => trim($row['client_position'] ?? ''),
                        'client_company' => trim($row['client_company'] ?? ''),
                        'review_text' => trim($row['review_text'] ?? ''),
                        'rating' => $this->validateRating($row['rating'] ?? 5),
                        'project_type' => trim($row['project_type'] ?? ''),
                        'is_featured' => $this->parseBooleanValue($row['is_featured'] ?? false),
                        'is_approved' => $this->parseBooleanValue($row['is_approved'] ?? false),
                        'sort_order' => intval($row['sort_order'] ?? 0),
                    ];
                    
                    // Basic validation
                    if (strlen($reviewData['client_name']) > 255) {
                        $errors[] = "Line {$lineNumber}: Client name exceeds 255 characters";
                        continue;
                    }
                    
                    if (empty($reviewData['review_text'])) {
                        $errors[] = "Line {$lineNumber}: Review text is required";
                        continue;
                    }
                    
                    Review::create($reviewData);
                    $importedCount++;
                    
                } catch (\Exception $e) {
                    $errors[] = "Line {$lineNumber}: " . $e->getMessage();
                }
            }
            
            // Clean up temporary file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            if (count($errors) > 0) {
                $errorMessage = "Import completed with " . count($errors) . " errors. Successfully imported: {$importedCount} reviews.";
                
                // Store errors in session for display
                session()->flash('import_errors_list', $errors);
                
                return redirect()->route('admin.reviews.show-import')
                    ->with('warning', $errorMessage);
            }

            return redirect()->route('admin.reviews.index')
                ->with('success', "Successfully imported {$importedCount} reviews.");
                
        } catch (\Exception $e) {
            // Clean up temporary file in case of error
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            return redirect()->route('admin.reviews.show-import')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    
    public function downloadTemplate()
    {
        $filename = 'reviews_import_template.xlsx';
        $filePath = storage_path('app/' . $filename);
        
        // Create Excel template file
        $writer = SimpleExcelWriter::create($filePath)
            ->addHeader([
                'client_name',
                'client_position',
                'client_company',
                'review_text',
                'rating',
                'project_type',
                'is_featured',
                'is_approved',
                'sort_order'
            ])
            ->addRow([
                'John Doe',
                'CEO',
                'Acme Corp',
                'Excellent service and great results!',
                '5',
                'Web Development',
                'true',
                'true',
                '1'
            ])
            ->addRow([
                'Jane Smith',
                'Marketing Director',
                'Tech Solutions',
                'Professional team with outstanding delivery.',
                '5',
                'Digital Marketing',
                'false',
                'true',
                '2'
            ])
            ->addRow([
                'Mike Johnson',
                'CTO',
                'StartupXYZ',
                'Innovative solutions that exceeded expectations.',
                '4',
                'Mobile App',
                'true',
                'true',
                '3'
            ]);
            
        $writer->close();
        
        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }
    
    public function showImport()
    {
        return view('admin.reviews.import');
    }
    
    /**
     * Validate and clean rating value
     */
    private function validateRating($rating): int
    {
        $rating = intval($rating);
        
        if ($rating < 1) {
            return 1;
        }
        
        if ($rating > 5) {
            return 5;
        }
        
        return $rating;
    }
    
    /**
     * Parse boolean values from various formats
     */
    private function parseBooleanValue($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            $value = strtolower(trim($value));
            return in_array($value, ['true', '1', 'yes', 'y', 'on']);
        }
        
        return (bool) $value;
    }
}