<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\CMSManager;
use Illuminate\View\View;

class ServiceController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    /**
     * Display a listing of services.
     */
    public function index(): View
    {
        $services = Service::where('is_active', true)->orderBy('order_index')->get();

        $page = $this->cmsManager->resolvePage('services', [
            'title' => 'Our Services',
            'breadcrumb_title' => 'Our <span>Services</span>',
            'image' => 'assets/img/breadcrumb-bg.jpg'
        ]);

        return view('services', compact('services', 'page'));
    }

    /**
     * Display a specific service.
     */
    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $allServices = Service::where('is_active', true)->orderBy('order_index')->get();
        
        return view('service-detail', compact('service', 'allServices'));
    }
}
