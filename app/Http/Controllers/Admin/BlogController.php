<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('author')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
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
        $data['slug'] = $request->filled('slug') ? Str::slug($request->input('slug')) : Str::slug($request->input('title'));
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
            $data['image'] = $request->file('featured_image')->store('assets/img/blog', 'public');
        }

        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('seo/og', 'public');
        }

        unset($data['featured_image_url'], $data['og_image_url']);

        $data['title'] = purify_html($data['title']);
        Blog::create($data);

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
        
        $data['slug'] = $request->filled('slug') ? Str::slug($request->input('slug')) : Str::slug($request->input('title'));
        $data['is_active'] = $request->has('is_published') || $request->has('is_active');

        if (!empty($data['featured_image_url'])) {
            if ($blog->image !== $data['featured_image_url']) {
                $this->deleteLocalMedia($blog->image);
            }

            $data['image'] = $data['featured_image_url'];
        }

        if (!empty($data['og_image_url'])) {
            if (($blog->og_image ?? null) !== $data['og_image_url']) {
                $this->deleteLocalMedia($blog->og_image ?? null);
            }

            $data['og_image'] = $data['og_image_url'];
        }

        if ($request->hasFile('featured_image')) {
            $this->deleteLocalMedia($blog->image);
            $data['image'] = $request->file('featured_image')->store('assets/img/blog', 'public');
        }

        // Handle OG Image
        if ($request->hasFile('og_image')) {
            $this->deleteLocalMedia($blog->og_image ?? null);
            $data['og_image'] = $request->file('og_image')->store('seo/og', 'public');
        }

        unset($data['featured_image_url'], $data['og_image_url']);

        $data['title'] = purify_html($data['title']);
        $data['content'] = purify_html($data['content'] ?? '');

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        $this->deleteLocalMedia($blog->image);
        $this->deleteLocalMedia($blog->og_image ?? null);

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
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
