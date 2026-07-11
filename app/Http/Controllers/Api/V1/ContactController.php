<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\TcRequest;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Repositories\Interfaces\TcRequestRepositoryInterface;
use App\Http\Resources\ServiceResource;
use App\Services\CMSManager;
use App\Services\CloudinaryUploadService;
use App\Http\Requests\TcRequestSubmitRequest;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected CMSManager $cmsManager;
    protected ServiceRepositoryInterface $serviceRepository;
    protected ContactRepositoryInterface $contactRepository;
    protected TcRequestRepositoryInterface $tcRequestRepository;

    public function __construct(
        CMSManager $cmsManager, 
        ServiceRepositoryInterface $serviceRepository,
        ContactRepositoryInterface $contactRepository,
        TcRequestRepositoryInterface $tcRequestRepository
    ) {
        $this->cmsManager = $cmsManager;
        $this->serviceRepository = $serviceRepository;
        $this->contactRepository = $contactRepository;
        $this->tcRequestRepository = $tcRequestRepository;
    }

    /**
     * Get contact page CMS data and services list.
     */
    public function index(): JsonResponse
    {
        $page = $this->cmsManager->resolvePage('contact', [
            'contact_address' => __('cms.contact.contact_address'),
            'contact_email' => __('cms.contact.contact_email'),
            'contact_phone' => __('cms.contact.contact_phone')
        ], true);

        $services = $this->serviceRepository->getActive();

        return response()->json([
            'page' => [
                'title' => $page->title ?? __('cms.contact.title'),
                'contact_address' => $page->contact_address ?? null,
                'contact_email' => $page->contact_email ?? null,
                'contact_phone' => $page->contact_phone ?? null,
                'meta_title' => $page->model->meta_title ?? null,
                'meta_description' => $page->model->meta_description ?? null,
            ],
            'services' => ServiceResource::collection($services),
        ]);
    }

    /**
     * Handle public contact form submission.
     */
    public function submit(StoreContactRequest $request): JsonResponse
    {
        // Honeypot check
        if (!empty($request->input('website_url'))) {
            return response()->json([
                'message' => 'Thank you for contacting us! We will get back to you shortly.',
            ], 201);
        }

        $validated = $request->validated();

        $contact = $this->contactRepository->create($validated);

        // Dispatch email notification to admin via Queue
        \Illuminate\Support\Facades\Notification::route('mail', config('mail.from.address'))
            ->notify(new \App\Notifications\NewContactNotification($contact));

        // Dispatch real-time admin panel notification to all admin/editor users
        $admins = \App\Models\User::whereIn('role', ['admin', 'editor'])->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\AdminAlertNotification(
            'contact',
            'New Contact Message',
            'New inquiry from ' . ($contact->name ?? 'Unknown') . ': ' . \Illuminate\Support\Str::limit($contact->subject ?? $contact->message ?? '', 50),
            route('admin.contacts.show', $contact),
        ));

        return response()->json([
            'message' => 'Thank you for contacting us! We will get back to you shortly.',
        ], 201);
    }

    /**
     * Handle technical consultation request submission.
     */
    /**
     * Handle technical consultation request submission.
     */
    public function tcRequestSubmit(TcRequestSubmitRequest $request): JsonResponse
    {
        // Honeypot check
        if (!empty($request->input('website_url'))) {
            return response()->json([
                'message' => 'Your request has been received. Our team will review it shortly.',
            ], 201);
        }

        $validated = $request->validated();

        $tcRequest = $this->tcRequestRepository->create([
            'email' => $validated['email'],
            'description' => $validated['description'],
            'service_id' => $validated['service_id'] ?? null,
            'budget_range' => $validated['budget_range'] ?? null,
            'timeline' => $validated['timeline'] ?? null,
            'attached_file' => null, // Will be updated by the job
        ]);

        if ($request->hasFile('attached_file')) {
            // Save temporarily to local disk
            $localPath = $request->file('attached_file')->store('temp', 'local');
            
            // Dispatch background job to upload to Cloudinary
            \App\Jobs\ProcessTcRequestUpload::dispatch($tcRequest, $localPath);
        }

        // Dispatch email notification to admin via Queue
        \Illuminate\Support\Facades\Notification::route('mail', config('mail.from.address'))
            ->notify(new \App\Notifications\NewTcRequestNotification($tcRequest));

        // Dispatch real-time admin panel notification to all admin/editor users
        $admins = \App\Models\User::whereIn('role', ['admin', 'editor'])->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\AdminAlertNotification(
            'tc_request',
            'New Service Request',
            'New consultation request from ' . ($tcRequest->email ?? 'Unknown'),
            route('admin.tc-requests.show', $tcRequest),
        ));

        return response()->json([
            'message' => 'Your request has been received. Our team will review it shortly.',
        ], 201);
    }
}
