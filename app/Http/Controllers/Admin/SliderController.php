<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Services\CloudinaryUploadService;

class SliderController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;
    protected SliderRepositoryInterface $sliderRepository;

    public function __construct(CloudinaryUploadService $uploadService, SliderRepositoryInterface $sliderRepository)
    {
        $this->uploadService = $uploadService;
        $this->sliderRepository = $sliderRepository;
    }

    public function index()
    {
        $sliders = $this->sliderRepository->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(StoreSliderRequest $request)
    {
        $data = $request->validated();

        if (!empty($data['image_url'])) {
            $data['image'] = $data['image_url'];
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadService->upload($request->file('image'), 'sliders');
        }

        unset($data['image_url']);

        $this->sliderRepository->create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created successfully.');
    }

    public function show(Slider $slider)
    {
        return view('admin.sliders.show', compact('slider'));
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $data = $request->validated();

        if (!empty($data['image_url'])) {
            if ($slider->image !== $data['image_url']) {
                $this->uploadService->delete($slider->image);
            }
            $data['image'] = $data['image_url'];
        } elseif ($request->hasFile('image')) {
            $this->uploadService->delete($slider->image);
            $data['image'] = $this->uploadService->upload($request->file('image'), 'sliders');
        } else {
            // Keep existing image if no new one is provided
            unset($data['image']);
        }

        unset($data['image_url']);

        $this->sliderRepository->update($slider->id, $data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        $this->uploadService->delete($slider->image);
        
        $this->sliderRepository->delete($slider->id);
        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted successfully.');
    }

    public function toggleActive(Slider $slider)
    {
        $this->authorize('update', $slider);

        $this->sliderRepository->update($slider->id, [
            'is_active' => !$slider->is_active
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider status updated successfully.');
    }
}
