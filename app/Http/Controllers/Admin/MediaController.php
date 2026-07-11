<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\StoreMediaRequest;
use Intervention\Image\Laravel\Facades\Image;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $media = Media::latest()->paginate(24);
        
        // Check if it's an AJAX request (for the picker modal)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'data' => $media->items(),
                'links' => (string) $media->links()
            ]);
        }

        return view('admin.media.index', compact('media'));
    }

    public function store(StoreMediaRequest $request)
    {
        $request->validated();

        $file = $request->file('file');
        
        // 1. Generate Secure File Name (randomized to prevent traversal & guessing)
        $extension = $file->getClientOriginalExtension();
        $safeFileName = Str::uuid() . '.' . $extension;
        
        $path = 'media/' . date('Y/m');
        $fullPath = $path . '/' . $safeFileName;

        // 2. Intervention Image: Strip EXIF and re-encode to sanitize malicious payloads
        // Using intervention/image-laravel
        $image = Image::read($file);
        
        // Re-encode to the original format. This strips out EXIF and any embedded PHP payloads
        $encodedImage = $image->encode();

        // 3. Store the clean image securely on local public disk
        Storage::disk('public')->put($fullPath, (string) $encodedImage);

        // Generate Alt Text using Gemini
        $altText = null;
        try {
            $base64Image = base64_encode(Storage::disk('public')->get($fullPath));
            $aiService = app(\App\Services\AI\AIService::class);
            $prompt = "Analyze this image and write a short, precise descriptive sentence suitable for an alt attribute. Output only the description, without any quotes or HTML.";
            $altText = $aiService->generate($prompt, [
                'image' => $base64Image,
                'mime_type' => $file->getMimeType(),
                'max_tokens' => 100,
                'temperature' => 0.4
            ]);
            $altText = trim($altText);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('AI Alt Text generation failed: ' . $e->getMessage());
        }

        // 4. Record in Database
        $media = Media::create([
            'file_name' => $file->getClientOriginalName(), // Keep original name for reference only
            'mime_type' => $file->getMimeType(),
            'disk' => 'public',
            'size' => Storage::disk('public')->size($fullPath),
            'url' => Storage::disk('public')->url($fullPath),
            'alt_text' => $altText,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'media' => $media
            ]);
        }

        return redirect()->back()->with('success', 'File uploaded securely.');
    }

    public function destroy(Media $media)
    {
        // Extract the path from the URL
        $path = str_replace(Storage::disk($media->disk)->url(''), '', $media->url);
        
        // Delete from storage
        if (Storage::disk($media->disk)->exists($path)) {
            Storage::disk($media->disk)->delete($path);
        }

        // Delete record
        $media->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
