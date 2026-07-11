<?php

namespace App\Jobs;

use App\Models\TcRequest;
use App\Services\CloudinaryUploadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessTcRequestUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tcRequest;
    public $localPath;

    /**
     * Create a new job instance.
     */
    public function __construct(TcRequest $tcRequest, string $localPath)
    {
        $this->tcRequest = $tcRequest;
        $this->localPath = $localPath;
    }

    /**
     * Execute the job.
     */
    public function handle(CloudinaryUploadService $uploadService): void
    {
        try {
            // Ensure the temporary local file exists
            if (!Storage::disk('local')->exists($this->localPath)) {
                Log::error("ProcessTcRequestUpload: Local file missing at {$this->localPath}");
                return;
            }

            // Get absolute path for Cloudinary uploader
            $absolutePath = Storage::disk('local')->path($this->localPath);

            // Upload to Cloudinary
            $cloudinaryPath = $uploadService->uploadFileFromPath($absolutePath, 'tc-requests');

            // Update database model
            $this->tcRequest->update(['attached_file' => $cloudinaryPath]);

        } catch (\Exception $e) {
            Log::error("ProcessTcRequestUpload Failed: " . $e->getMessage());
        } finally {
            // Always clean up the temporary file
            if (Storage::disk('local')->exists($this->localPath)) {
                Storage::disk('local')->delete($this->localPath);
            }
        }
    }
}
