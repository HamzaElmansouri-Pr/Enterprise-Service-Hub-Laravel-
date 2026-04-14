<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Services\CloudinaryUploadService;

class SliderController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;

    public function __construct(CloudinaryUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        // $this->authorize('viewAny', Slider::class);
        $sliders = Slider::latest()->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        // $this->authorize('create', Slider::class);
        return view('admin.sliders.create');
    }

    public function store(StoreSliderRequest $request)
    {
        // $this->authorize('create', Slider::class);
        $data = $request->validated();

        if (!empty($data['image_url'])) {
            $data['image'] = $data['image_url'];
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadService->upload($request->file('image'), 'sliders');
        }

        unset($data['image_url']);

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    public function show(Slider $slider)
    {
        // $this->authorize('view', $slider);
        return view('admin.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider)
    {
        // $this->authorize('update', $slider);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        // $this->authorize('update', $slider);
        
        $data = $request->validated();

        if (!empty($data['image_url'])) {
            if ($slider->image !== $data['image_url']) {
                $this->uploadService->delete($slider->image);
            }

            $data['image'] = $data['image_url'];
        }

        if ($request->hasFile('image')) {
            $this->uploadService->delete($slider->image);
            $data['image'] = $this->uploadService->upload($request->file('image'), 'sliders');
        }

        unset($data['image_url']);

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        $this->authorize('delete', $slider);
        
        $this->uploadService->delete($slider->image);
        
        $slider->delete();
        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully.');
    }

    public function toggleActive(Slider $slider)
    {
        // $this->authorize('update', $slider);
        
        $slider->update([
            'is_active' => !$slider->is_active
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider status updated successfully.');
    }
}
