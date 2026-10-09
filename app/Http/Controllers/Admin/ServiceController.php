<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;
    protected ServiceRepositoryInterface $serviceRepository;

    public function __construct(CloudinaryUploadService $uploadService, ServiceRepositoryInterface $serviceRepository)
    {
        $this->uploadService = $uploadService;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Service::class);
        $services = $this->serviceRepository->paginate(10, [], ['order_index' => 'asc']);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Service::class);
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create', Service::class);
        $data = $request->validated();
        
        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $titleForSlug = is_array($data['title']) ? ($data['title']['en'] ?? reset($data['title'])) : $data['title'];
            $data['slug'] = Str::slug($titleForSlug);
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

        if (isset($data['description']) && is_array($data['description'])) {
            $data['description'] = array_map('purify_html', $data['description']);
        }
        if (isset($data['subtitle']) && is_array($data['subtitle'])) {
            $data['subtitle'] = array_map('purify_html', $data['subtitle']);
        }

        if ($request->hasFile('icon_upload')) {
             $data['icon'] = $this->uploadService->upload($request->file('icon_upload'), 'services/icons');
        } elseif (empty($data['icon'])) {
             // Default icon if not provided
             $data['icon'] = 'flaticon-settings';
        }

        unset($data['image_url'], $data['og_image_url']);

        $serviceModel = $this->serviceRepository->create($data);

        if (empty($data['meta_description'])) {
            \App\Jobs\GenerateSeoMetaJob::dispatch($serviceModel);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $this->authorize('view', $service);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $this->authorize('update', $service);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('update', $service);
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $titleForSlug = is_array($data['title']) ? ($data['title']['en'] ?? reset($data['title'])) : $data['title'];
            $data['slug'] = Str::slug($titleForSlug);
        }

        if (!empty($data['image_url'])) {
            if ($service->image !== $data['image_url']) {
                $this->uploadService->delete($service->image);
            }
            $data['image'] = $data['image_url'];
        } elseif ($request->hasFile('image')) {
            $this->uploadService->delete($service->image);
            $data['image'] = $this->uploadService->upload($request->file('image'), 'services');
        } else {
            unset($data['image']);
        }

        // Handle OG Image
        if (!empty($data['og_image_url'])) {
            if (($service->og_image ?? null) !== $data['og_image_url']) {
                $this->uploadService->delete($service->og_image ?? null);
            }
            $data['og_image'] = $data['og_image_url'];
        } elseif ($request->hasFile('og_image')) {
            $this->uploadService->delete($service->og_image ?? null);
            $data['og_image'] = $this->uploadService->upload($request->file('og_image'), 'seo/og');
        } else {
            unset($data['og_image']);
        }

        if (isset($data['description']) && is_array($data['description'])) {
            $data['description'] = array_map('purify_html', $data['description']);
        }
        if (isset($data['subtitle']) && is_array($data['subtitle'])) {
            $data['subtitle'] = array_map('purify_html', $data['subtitle']);
        }

        if ($request->hasFile('icon_upload')) {
            $data['icon'] = $this->uploadService->upload($request->file('icon_upload'), 'services/icons');
        } else {
            unset($data['icon']);
        }

        unset($data['image_url'], $data['og_image_url']);

        $this->serviceRepository->update($service->id, $data);

        if (empty($data['meta_description'])) {
            \App\Jobs\GenerateSeoMetaJob::dispatch($service->refresh());
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $this->serviceRepository->delete($service->id);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Service $service)
    {
        $this->authorize('update', $service);
        $service->update(['is_active' => !$service->is_active]);

        return back()->with('success', 'Service status updated successfully.');
    }
}
