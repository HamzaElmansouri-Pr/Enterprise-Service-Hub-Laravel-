<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::ordered()->paginate(10);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $serviceDir = public_path('assets/img/service');
            if (!file_exists($serviceDir)) {
                mkdir($serviceDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($serviceDir, $imageName);
            $validated['image'] = 'assets/img/service/' . $imageName;
        }

        // Convert features array to JSON
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']); // Remove empty values
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully!');
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
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $serviceDir = public_path('assets/img/service');
            if (!file_exists($serviceDir)) {
                mkdir($serviceDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($serviceDir, $imageName);
            $validated['image'] = 'assets/img/service/' . $imageName;
        }

        // Convert features array to JSON
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features']); // Remove empty values
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Delete image if exists
        if ($service->image && file_exists(public_path($service->image))) {
            unlink(public_path($service->image));
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully!');
    }

    /**
     * Toggle service status
     */
    public function toggleStatus(Service $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        
        $status = $service->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Service {$status} successfully!");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Service $service)
    {
        $service->update(['is_featured' => !$service->is_featured]);
        
        $status = $service->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()
            ->with('success', "Service {$status} successfully!");
    }
}
