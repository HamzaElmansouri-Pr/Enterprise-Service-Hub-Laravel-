<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Centralized service for uploading files.
 * When using Cloudinary, stores the full secure URL in the database.
 * When using local storage, stores the relative path.
 */
class CloudinaryUploadService
{
    /**
     * Upload a file and return the URL/path to store in the database.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $folder The folder/prefix to store in (e.g., 'projects', 'sliders')
     * @return string The full URL (Cloudinary) or relative path (local)
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        $diskName = config('filesystems.default');

        if ($diskName === 'cloudinary') {
            return $this->uploadToCloudinary($file, $folder);
        }

        // Fallback: local or S3 storage
        $path = $file->store($folder, 'public');
        return 'storage/' . $path;
    }

    /**
     * Upload directly to Cloudinary and return the full secure URL.
     */
    protected function uploadToCloudinary(UploadedFile $file, string $folder): string
    {
        $cloudinary = app(\Cloudinary\Cloudinary::class);

        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'auto',
        ]);

        return $result['secure_url'];
    }

    /**
     * Delete a file from storage.
     *
     * @param string|null $path The path or URL of the file
     */
    public function delete(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        // Skip external URLs that are not from our Cloudinary
        if ($this->isExternalUrl($path) && !$this->isCloudinaryUrl($path)) {
            return;
        }

        // Skip theme assets
        if (str_starts_with($path, 'assets/')) {
            return;
        }

        $diskName = config('filesystems.default');

        if ($diskName === 'cloudinary' && $this->isCloudinaryUrl($path)) {
            $this->deleteFromCloudinary($path);
            return;
        }

        // Local storage cleanup
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        Storage::disk('public')->delete($path);
    }

    /**
     * Delete a file from Cloudinary by its URL.
     */
    protected function deleteFromCloudinary(string $url): void
    {
        try {
            // Extract public_id from URL
            // URL format: https://res.cloudinary.com/cloud_name/image/upload/v1234/folder/filename.ext
            $parsed = parse_url($url);
            $pathParts = explode('/upload/', $parsed['path'] ?? '');

            if (count($pathParts) < 2) {
                return;
            }

            // Remove the version prefix (v1234567890/) and file extension
            $publicIdWithVersion = $pathParts[1];
            $publicId = preg_replace('/^v\d+\//', '', $publicIdWithVersion);
            $publicId = preg_replace('/\.[^.]+$/', '', $publicId);

            $cloudinary = app(\Cloudinary\Cloudinary::class);
            $cloudinary->uploadApi()->destroy($publicId);
        } catch (\Throwable $e) {
            // Silently fail - the file may already be deleted
            report($e);
        }
    }

    protected function isExternalUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }

    protected function isCloudinaryUrl(string $path): bool
    {
        return str_contains($path, 'res.cloudinary.com');
    }
}
