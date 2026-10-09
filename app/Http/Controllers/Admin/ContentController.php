<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Services\CMSManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdateContentRequest;

class ContentController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    public function index()
    {
        $sections = \App\Models\Section::all()->groupBy('type');
        return view('admin.content.index', compact('sections'));
    }

    public function toggleActive(string $type)
    {
        $section = Section::where('type', $type)->firstOrFail();
        $section->is_active = !$section->is_active;
        $section->save();

        if ($type === 'site-info' || $type === 'footer-content') {
            cache()->forget('site_info');
            cache()->forget('api_global_data');
        }

        return response()->json([
            'success' => true,
            'is_active' => $section->is_active,
            'message' => 'Section status updated.'
        ]);
    }

    public function edit(string $type)
    {
        $section = $this->cmsManager->getSection($type);
        $content = $this->cmsManager->getSectionContentBlocks($section);
        
        $data = [
            'content' => $content,
            'contentType' => $type,
        ];

        if ($type === 'services-list') {
            $services = \App\Models\Service::where('is_active', true)->orderBy('title')->get();
            $featuredServices = collect($content['featured_services'] ?? []);
            
            $data['services'] = $services->map(function($service) use ($featuredServices) {
                $config = $featuredServices->firstWhere('id', $service->id);
                $service->is_featured = !empty($config);
                $service->featured_order = $service->is_featured ? ($config['order'] ?? 0) : 0;
                return $service;
            });
        }

        if ($type === 'projects-list') {
            $featuredConfig = $data['content']['featured_projects'] ?? [];
            $data['projects'] = \App\Models\Project::where('is_active', true)->get()->map(function($project) use ($featuredConfig) {
                $config = collect($featuredConfig)->firstWhere('id', $project->id);
                $project->is_featured = !is_null($config);
                $project->featured_order = $config['order'] ?? 0;
                return $project;
            });
        }
        
        return view("admin.content.edit", $data);
    }

    public function update(UpdateContentRequest $request, string $type)
    {
        $validatedData = $request->validated();
        $section = $this->cmsManager->getSection($type);

        $this->cmsManager->updateSection($section, $validatedData, $request);

        return redirect()->back()->with('success', 'Content updated successfully.');
    }

    public function destroyImage(string $type, string $key)
    {
        Gate::authorize('deleteImage', Section::class);

        $section = Section::where('type', $type)->with('contentBlocks')->firstOrFail();
        $block = $section->contentBlocks()->where('key', $key)->first();
        
        if ($block) {
            if (str_starts_with($block->content, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $block->content));
            }
            $block->delete();
        }

        if ($type === 'site-info' || $type === 'footer-content') {
            cache()->forget('site_info');
            cache()->forget('api_global_data');
        }

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function updateItem(Request $request, string $type, string $key, int $index)
    {
        $section = $this->cmsManager->getSection($type);
        
        $itemData = $request->input('item', []);
        
        $updatedItem = $this->cmsManager->updateSectionItem($section, $key, $index, $itemData, $request);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully.',
            'item' => $updatedItem,
            'image_url' => isset($updatedItem['image']) ? asset($updatedItem['image']) : null
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.type' => 'required|string',
            'order.*.order' => 'required|integer',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            foreach ($request->input('order') as $item) {
                Section::where('type', $item['type'])->update(['order_index' => $item['order']]);
            }
        });

        return response()->json(['success' => true, 'message' => 'Sections reordered successfully.']);
    }
}
