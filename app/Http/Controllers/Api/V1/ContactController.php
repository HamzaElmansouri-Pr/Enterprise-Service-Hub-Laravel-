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
            'title' => __('cms.contact.title'),
        ], true);

        $headerFields = [
            'eyebrow',
            'title',
            'breadcrumb_title',
            'description',
            'button_text',
            'button_url',
            'grid_eyebrow',
            'grid_title',
            'grid_description',
            'image',
        ];
        $contactHeader = $page->model?->sections->firstWhere('type', 'contact-page-header');
        $configuredFields = $contactHeader
            ? $contactHeader->contentBlocks->pluck('key')->intersect($headerFields)->values()->all()
            : [];

        $sanitizeContactDetail = function (?string $value): ?string {
            if ($value === null) {
                return null;
            }
            $trimmed = trim($value);
            if ($trimmed === '' || in_array($trimmed, ['null', 'test@gmail.com', '+1 (555) 123-4567', '123 Business Street, City, State 12345'], true)) {
                return null;
            }
            return $trimmed;
        };

        $contactInfoSection = $page->model?->sections->firstWhere('type', 'contact-info')
            ?? \App\Models\Section::where('type', 'contact-info')->first();

        $contactAddress = $sanitizeContactDetail($page->contact_address ?? ($contactInfoSection?->getContent('contact_address') ?: null));
        $contactEmail = $sanitizeContactDetail($page->contact_email ?? ($contactInfoSection?->getContent('contact_email') ?: null));
        $contactPhone = $sanitizeContactDetail($page->contact_phone ?? ($contactInfoSection?->getContent('contact_phone') ?: null));

        $locale = app()->getLocale();
        $services = \Illuminate\Support\Facades\Cache::remember("api_contact_services_{$locale}", 1800, function() {
            return $this->serviceRepository->getActive();
        });

        return response()->json([
            'page' => [
                'title' => $page->title ?? __('cms.contact.title'),
                'breadcrumb_title' => $page->breadcrumb_title ?? ($page->title ?? __('cms.contact.title')),
                'image' => $page->image ?? null,
                'meta_title' => $page->model?->meta_title ?? null,
                'meta_description' => $page->model?->meta_description ?? null,
                'eyebrow' => $page->eyebrow ?? null,
                'description' => $page->description ?? null,
                'button_text' => $page->button_text ?? null,
                'button_url' => $page->button_url ?? null,
                'grid_eyebrow' => $page->grid_eyebrow ?? null,
                'grid_title' => $page->grid_title ?? null,
                'grid_description' => $page->grid_description ?? null,
                'contact_title' => $page->contact_title ?? null,
                'contact_description' => $page->contact_description ?? null,
                'contact_logo' => $page->contact_logo ?? null,
                'contact_address' => $contactAddress,
                'contact_email' => $contactEmail,
                'contact_phone' => $contactPhone,
                'configured_fields' => $configuredFields,
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
        
        if (empty($validated['subject'])) {
            $validated['subject'] = 'No Subject';
        }

        $contact = $this->contactRepository->create($validated);

        // Dispatch email notification to admin via Queue
        \Illuminate\Support\Facades\Notification::route('mail', config('mail.from.address'))
            ->notify(new \App\Notifications\NewContactNotification($contact));

        // Dispatch real-time admin panel notification to all admin/editor users
        $admins = \Illuminate\Support\Facades\Cache::remember('admin_users', 3600, function() {
            return \App\Models\User::whereIn('role', ['admin', 'editor'])->get();
        });
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
        $admins = \Illuminate\Support\Facades\Cache::remember('admin_users', 3600, function() {
            return \App\Models\User::whereIn('role', ['admin', 'editor'])->get();
        });
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
