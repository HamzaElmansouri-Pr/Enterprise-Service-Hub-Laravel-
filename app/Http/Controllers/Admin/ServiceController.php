<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;

    public function __construct(CloudinaryUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::orderBy('order_index')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        
        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (!empty($data['image_url'])) {
            $data['image'] = $data['image_url'];
        }

        if (!empty($data['og_image_url'])) {
            $data['og_image'] = $data['og_image_url'];
        }
        
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadService->upload($request->file('image'), 'services');
        }

        $data['description'] = purify_html($data['description'] ?? '');
        $data['subtitle'] = purify_html($data['subtitle'] ?? '');

        if ($request->hasFile('icon')) {
             $data['icon'] = $this->uploadService->upload($request->file('icon'), 'services/icons');
        } elseif (empty($data['icon'])) {
             // Default icon if not provided
             $data['icon'] = 'flaticon-settings';
        }

           unset($data['image_url'], $data['og_image_url']);

        Service::create($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (!empty($data['image_url'])) {
            if ($service->image !== $data['image_url']) {
                $this->uploadService->delete($service->image);
            }

            $data['image'] = $data['image_url'];
        }

        if (!empty($data['og_image_url'])) {
            if (($service->og_image ?? null) !== $data['og_image_url']) {
                $this->uploadService->delete($service->og_image ?? null);
            }

            $data['og_image'] = $data['og_image_url'];
        }

        if ($request->hasFile('image')) {
            $this->uploadService->delete($service->image);
            $data['image'] = $this->uploadService->upload($request->file('image'), 'services');
        }

        // Handle OG Image
        if ($request->hasFile('og_image')) {
            $this->uploadService->delete($service->og_image ?? null);
            $data['og_image'] = $this->uploadService->upload($request->file('og_image'), 'seo/og');
        }

        $data['description'] = purify_html($data['description'] ?? '');
        $data['subtitle'] = purify_html($data['subtitle'] ?? '');

        if ($request->hasFile('icon')) {
            $data['icon'] = $this->uploadService->upload($request->file('icon'), 'services/icons');
        }

        unset($data['image_url'], $data['og_image_url']);

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
