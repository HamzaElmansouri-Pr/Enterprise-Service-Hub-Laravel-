<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Http\Requests\Admin\UpdatePartnerRequest;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PartnerController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;

    public function __construct(CloudinaryUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

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
            $data['logo'] = $this->uploadService->upload($request->file('logo'), 'partners');
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
                $this->uploadService->delete($partner->logo);
            }

            $data['logo'] = $data['logo_url'];
        }
        
        if ($request->hasFile('logo')) {
            $this->uploadService->delete($partner->logo);
            $data['logo'] = $this->uploadService->upload($request->file('logo'), 'partners');
        }

        unset($data['logo_url']);

        $partner->update($data);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        $this->authorize('delete', $partner);

        $this->uploadService->delete($partner->logo);

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
