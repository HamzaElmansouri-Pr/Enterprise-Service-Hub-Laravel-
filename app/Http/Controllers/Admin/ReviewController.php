<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Requests\Admin\StoreReviewRequest;
use App\Http\Requests\Admin\UpdateReviewRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::orderBy('order_index')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['order_index'] = $request->input('order_index', 0);

        if (!empty($data['client_image_url'])) {
            $data['client_image'] = $data['client_image_url'];
        }

        if ($request->hasFile('client_image')) {
            $data['client_image'] = $request->file('client_image')->store('assets/img/testimonial', 'public');
        }

        unset($data['client_image_url']);

        Review::create($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $data = $request->validated();
        
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        if (!empty($data['client_image_url'])) {
            if ($review->client_image !== $data['client_image_url']) {
                $this->deleteLocalMedia($review->client_image);
            }

            $data['client_image'] = $data['client_image_url'];
        }

        if ($request->hasFile('client_image')) {
            $this->deleteLocalMedia($review->client_image);
            $data['client_image'] = $request->file('client_image')->store('assets/img/testimonial', 'public');
        }

        unset($data['client_image_url']);

        $review->update($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $this->deleteLocalMedia($review->client_image);

        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    private function deleteLocalMedia(?string $path): void
    {
        if (empty($path) || $this->isExternalUrl($path) || str_starts_with($path, 'assets/')) {
            return;
        }

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        Storage::disk('public')->delete($path);
    }

    private function isExternalUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }
}
