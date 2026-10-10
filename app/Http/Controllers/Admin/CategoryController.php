<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::withCount('projects')
            ->orderBy('order_index', 'asc')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $nameForSlug = is_array($data['name']) ? ($data['name']['en'] ?? reset($data['name'])) : $data['name'];
            $data['slug'] = Str::slug((string) $nameForSlug);
        }

        if (function_exists('purify_html')) {
            if (isset($data['name'])) {
                $data['name'] = is_array($data['name']) ? array_map('strip_tags', $data['name']) : strip_tags($data['name']);
            }
            if (isset($data['description'])) {
                $data['description'] = is_array($data['description']) ? array_map('purify_html', $data['description']) : purify_html($data['description']);
            }
        }

        $this->categoryRepository->create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $nameForSlug = is_array($data['name']) ? ($data['name']['en'] ?? reset($data['name'])) : $data['name'];
            $data['slug'] = Str::slug((string) $nameForSlug);
        }

        if (function_exists('purify_html')) {
            if (isset($data['name'])) {
                $data['name'] = is_array($data['name']) ? array_map('strip_tags', $data['name']) : strip_tags($data['name']);
            }
            if (isset($data['description'])) {
                $data['description'] = is_array($data['description']) ? array_map('purify_html', $data['description']) : purify_html($data['description']);
            }
        }

        $this->categoryRepository->update($category->id, $data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category->id);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Request $request, Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_active' => $category->is_active,
                'message' => 'Status updated successfully.',
            ]);
        }

        return redirect()->back()->with('success', 'Category status updated successfully.');
    }
}
