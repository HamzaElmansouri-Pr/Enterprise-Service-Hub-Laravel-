<?php

declare(strict_types=1);

namespace App\Helpers;

class CloudinaryHelper
{
    /**
     * Generate an optimized Cloudinary URL with transformations.
     *
     * @param string|null $url The original Cloudinary secure_url
     * @param int|null $width The target width for responsive sizing
     * @param string $format The format (auto for WebP/AVIF, or webp)
     * @param string $quality The quality (auto is recommended)
     * @return string|null
     */
    public static function optimizeUrl(?string $url, ?int $width = null, string $format = 'auto', string $quality = 'auto'): ?string
    {
        if (empty($url) || !str_contains($url, 'res.cloudinary.com')) {
            return $url;
        }

        // Parse URL to inject transformations
        // URL format: https://res.cloudinary.com/cloud_name/image/upload/v1234/folder/filename.ext
        $parsed = parse_url($url);
        if (!isset($parsed['path'])) {
            return $url;
        }

        $pathParts = explode('/upload/', $parsed['path']);
        if (count($pathParts) < 2) {
            return $url;
        }

        $transformations = [];
        
        if ($format) {
            $transformations[] = 'f_' . $format;
        }
        
        if ($quality) {
            $transformations[] = 'q_' . $quality;
        }
        
        if ($width) {
            $transformations[] = 'w_' . $width;
            $transformations[] = 'c_limit'; // Only scale down, never up
        }

        if (empty($transformations)) {
            return $url;
        }

        $transformationString = implode(',', $transformations);
        $newPath = $pathParts[0] . '/upload/' . $transformationString . '/' . $pathParts[1];

        return $parsed['scheme'] . '://' . $parsed['host'] . $newPath;
    }

    /**
     * Generate a srcset string for responsive images.
     *
     * @param string|null $url The original Cloudinary URL
     * @param array $breakpoints The array of widths for srcset
     * @return string|null
     */
    public static function generateSrcSet(?string $url, array $breakpoints = [320, 640, 768, 1024, 1280, 1920]): ?string
    {
        if (empty($url) || !str_contains($url, 'res.cloudinary.com')) {
            return null;
        }

        $srcSet = [];
        foreach ($breakpoints as $width) {
            $optimizedUrl = self::optimizeUrl($url, $width);
            if ($optimizedUrl) {
                $srcSet[] = "{$optimizedUrl} {$width}w";
            }
        }

        return empty($srcSet) ? null : implode(', ', $srcSet);
    }
}
