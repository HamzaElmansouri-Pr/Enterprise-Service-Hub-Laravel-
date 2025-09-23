<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $reviewDir = public_path('assets/img/review');
            if (!file_exists($reviewDir)) {
                mkdir($reviewDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($reviewDir, $imageName);
            $validated['image'] = 'assets/img/review/' . $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_approved'] = $request->has('is_approved');

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($review->image && file_exists(public_path($review->image))) {
                unlink(public_path($review->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $reviewDir = public_path('assets/img/review');
            if (!file_exists($reviewDir)) {
                mkdir($reviewDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($reviewDir, $imageName);
            $validated['image'] = 'assets/img/review/' . $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_approved'] = $request->has('is_approved');

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Delete image if exists
        if ($review->image && file_exists(public_path($review->image))) {
            unlink(public_path($review->image));
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
}