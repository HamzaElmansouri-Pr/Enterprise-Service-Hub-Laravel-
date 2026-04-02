<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Http\Requests\Admin\UpdatePartnerRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PartnerController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $partners = Partner::orderBy('order_index')->paginate(10);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(StorePartnerRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners', 'public');
            $data['logo'] = 'storage/' . $path;
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $data = $request->validated();
        
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($partner->logo && str_starts_with($partner->logo, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $partner->logo));
            }
            
            $path = $request->file('logo')->store('partners', 'public');
            $data['logo'] = 'storage/' . $path;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $this->authorize('delete', $partner);

        if ($partner->logo && str_starts_with($partner->logo, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $partner->logo));
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
