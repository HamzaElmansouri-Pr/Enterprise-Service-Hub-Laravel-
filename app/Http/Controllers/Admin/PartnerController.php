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

        if (!empty($data['logo_url'])) {
            $data['logo'] = $data['logo_url'];
        }
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('partners');
            $data['logo'] = $path;
        }

        unset($data['logo_url']);

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

        if (!empty($data['logo_url'])) {
            if ($partner->logo !== $data['logo_url']) {
                $this->deleteLocalLogo($partner->logo);
            }

            $data['logo'] = $data['logo_url'];
        }
        
        if ($request->hasFile('logo')) {
            $this->deleteLocalLogo($partner->logo);
            
            $path = $request->file('logo')->store('partners');
            $data['logo'] = $path;
        }

        unset($data['logo_url']);

        $partner->update($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $this->authorize('delete', $partner);

        $this->deleteLocalLogo($partner->logo);

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }

    private function deleteLocalLogo(?string $path): void
    {
        Storage::delete($path);
    }

    private function isExternalUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }
}
