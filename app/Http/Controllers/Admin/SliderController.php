<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    use AuthorizesRequests;

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

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
            $data['image'] = $imagePath;
        }

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

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $imagePath = $request->file('image')->store('sliders', 'public');
            $data['image'] = $imagePath;
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        // $this->authorize('delete', $slider);
        
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        
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
