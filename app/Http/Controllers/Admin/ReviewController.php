<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Http\Requests\Admin\StoreReviewRequest;
use App\Http\Requests\Admin\UpdateReviewRequest;
use App\Services\CloudinaryUploadService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;
    protected ReviewRepositoryInterface $reviewRepository;

    public function __construct(CloudinaryUploadService $uploadService, ReviewRepositoryInterface $reviewRepository)
    {
        $this->uploadService = $uploadService;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = $this->reviewRepository->paginate(10, [], ['order_index' => 'asc']);
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
            $data['client_image'] = $this->uploadService->upload($request->file('client_image'), 'testimonials');
        }

        unset($data['client_image_url']);

        if (isset($data['review_text'])) {
            $data['review_text'] = is_array($data['review_text']) ? array_map('purify_html', $data['review_text']) : purify_html($data['review_text']);
        }

        $this->reviewRepository->create($data);

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
                $this->uploadService->delete($review->client_image);
            }

            $data['client_image'] = $data['client_image_url'];
        }

        if ($request->hasFile('client_image')) {
            $this->uploadService->delete($review->client_image);
            $data['client_image'] = $this->uploadService->upload($request->file('client_image'), 'testimonials');
        }

        unset($data['client_image_url']);

        if (isset($data['review_text'])) {
            $data['review_text'] = is_array($data['review_text']) ? array_map('purify_html', $data['review_text']) : purify_html($data['review_text']);
        }

        $this->reviewRepository->update($review->id, $data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->uploadService->delete($review->client_image);

        $this->reviewRepository->delete($review->id);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
