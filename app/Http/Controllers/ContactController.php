<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\TcRequest;
use App\Models\Service;
use App\Services\CMSManager;
use App\Http\Requests\TcRequestSubmitRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    /**
     * Display the contact page.
     */
    public function index(): View
    {
        $page = $this->cmsManager->resolvePage('contact', [
            'contact_address' => '123 Business Street, City, State 12345',
            'contact_email' => 'test@gmail.com',
            'contact_phone' => '+1 (555) 123-4567'
        ]);

        $services = Service::where('is_active', true)->orderBy('order_index')->get();
        
        return view('contact', compact('page', 'services'));
    }

    /**
     * Handle public contact form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }

    /**
     * Handle consultant request submission.
     */
    public function tcRequestSubmit(TcRequestSubmitRequest $request)
    {
        $validated = $request->validated();

        $path = null;
        if ($request->hasFile('attached_file')) {
            $path = $request->file('attached_file')->store('tc-requests', 'public');
        }

        TcRequest::create([
            'email' => $validated['email'],
            'description' => $validated['description'],
            'attached_file' => $path,
            'service_id' => $validated['service_id'] ?? null,
        ]);

        return back()->with('success', 'Your request has been received. Our team will review it shortly.');
    }
}
