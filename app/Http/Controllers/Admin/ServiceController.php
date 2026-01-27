<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
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
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = 'storage/' . $path;
        }

        if ($request->hasFile('icon')) {
             // If icon is an image upload (svg/png)
             $path = $request->file('icon')->store('services/icons', 'public');
             $data['icon'] = 'storage/' . $path;
        } elseif (empty($data['icon'])) {
             // Default icon if not provided
             $data['icon'] = 'flaticon-settings';
        }

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

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                $oldPath = str_replace('storage/', '', $service->image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('image')->store('services', 'public');
            $data['image'] = 'storage/' . $path;
        }

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('services/icons', 'public');
            $data['icon'] = 'storage/' . $path;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
             $oldPath = str_replace('storage/', '', $service->image);
             Storage::disk('public')->delete($oldPath);
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
