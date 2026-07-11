<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;
    protected BlogRepositoryInterface $blogRepository;

    public function __construct(CloudinaryUploadService $uploadService, BlogRepositoryInterface $blogRepository)
    {
        $this->uploadService = $uploadService;
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Blog::with('author');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title->en', 'like', "%{$search}%")
                  ->orWhere('title->ar', 'like', "%{$search}%")
                  ->orWhere('title->fr', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_active', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $blogs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Inline update a specific field via AJAX.
     */
    public function inlineUpdate(\Illuminate\Http\Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
        ]);

        $blog->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
        ]);
    }

    /**
     * Perform bulk actions on selected blogs.
     */
    public function bulkAction(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete,publish,draft',
            'ids' => 'required|json'
        ]);

        $ids = json_decode($validated['ids'], true);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'No items selected.');
        }

        switch ($validated['action']) {
            case 'delete':
                Blog::whereIn('id', $ids)->delete();
                $message = 'Selected blogs moved to trash.';
                break;
            case 'publish':
                Blog::whereIn('id', $ids)->update(['is_active' => true]);
                $message = 'Selected blogs published.';
                break;
            case 'draft':
                Blog::whereIn('id', $ids)->update(['is_active' => false]);
                $message = 'Selected blogs moved to draft.';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();
        
        $data['author_id'] = Auth::id();
        $titleInput = $request->input('title');
        $titleForSlug = is_array($titleInput) ? ($titleInput['en'] ?? reset($titleInput)) : $titleInput;
        $data['slug'] = $request->filled('slug') ? Str::slug($request->input('slug')) : Str::slug($titleForSlug);
        $data['is_active'] = $request->has('is_published') || $request->has('is_active');
        
        // Handle publishing date
        if (empty($data['published_at']) && $data['is_active']) {
            $data['published_at'] = now();
        }

        if (!empty($data['featured_image_url'])) {
            $data['image'] = $data['featured_image_url'];
        }

        if (!empty($data['og_image_url'])) {
            $data['og_image'] = $data['og_image_url'];
        }

        if ($request->hasFile('featured_image')) {
            $data['image'] = $this->uploadService->upload($request->file('featured_image'), 'blog');
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $this->uploadService->upload($request->file('og_image'), 'seo/og');
        }

        unset($data['featured_image_url'], $data['og_image_url']);

        if (isset($data['title'])) {
            $data['title'] = is_array($data['title']) ? array_map('purify_html', $data['title']) : purify_html($data['title']);
        }
        if (isset($data['content'])) {
            $data['content'] = is_array($data['content']) ? array_map('purify_html', $data['content']) : purify_html($data['content']);
        }
        
        $blog = $this->blogRepository->create($data);

        if (empty($data['meta_description'])) {
            \App\Jobs\GenerateSeoMetaJob::dispatch($blog);
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();
        
        $titleInput = $request->input('title');
        $titleForSlug = is_array($titleInput) ? ($titleInput['en'] ?? reset($titleInput)) : $titleInput;
        $data['slug'] = $request->filled('slug') ? Str::slug($request->input('slug')) : Str::slug($titleForSlug);
        $data['is_active'] = $request->has('is_published') || $request->has('is_active');

        if (!empty($data['featured_image_url'])) {
            if ($blog->image !== $data['featured_image_url']) {
                $this->uploadService->delete($blog->image);
            }

            $data['image'] = $data['featured_image_url'];
        }

        if (!empty($data['og_image_url'])) {
            if (($blog->og_image ?? null) !== $data['og_image_url']) {
                $this->uploadService->delete($blog->og_image ?? null);
            }

            $data['og_image'] = $data['og_image_url'];
        }

        if ($request->hasFile('featured_image')) {
            $this->uploadService->delete($blog->image);
            $data['image'] = $this->uploadService->upload($request->file('featured_image'), 'blog');
        }

        // Handle OG Image
        if ($request->hasFile('og_image')) {
            $this->uploadService->delete($blog->og_image ?? null);
            $data['og_image'] = $this->uploadService->upload($request->file('og_image'), 'seo/og');
        }

        unset($data['featured_image_url'], $data['og_image_url']);

        if (isset($data['title'])) {
            $data['title'] = is_array($data['title']) ? array_map('purify_html', $data['title']) : purify_html($data['title']);
        }
        if (isset($data['content'])) {
            $data['content'] = is_array($data['content']) ? array_map('purify_html', $data['content']) : purify_html($data['content']);
        }

        $this->blogRepository->update($blog->id, $data);

        if (empty($data['meta_description'])) {
            \App\Jobs\GenerateSeoMetaJob::dispatch($blog->refresh());
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->uploadService->delete($blog->image);
        $this->uploadService->delete($blog->og_image ?? null);

        $this->blogRepository->delete($blog->id);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}
