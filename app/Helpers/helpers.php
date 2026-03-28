<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('resolve_image_url')) {
    /**
     * Resolve image URL handling different storage and asset paths.
     *
     * @param string|null $path
     * @return string|null
     */
    function resolve_image_url($path)
    {
        if (empty($path)) {
            return null;
        }

        // If it's already a full URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // If it's a theme asset
        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        // If it already has storage/ prefix (common in some CMS/DB setups)
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8); // Remove 'storage/'
        }

        return Storage::url($path);
    }
}

if (!function_exists('purify_html')) {
    /**
     * Sanitize and purify HTML content to prevent XSS.
     *
     * @param string|null $html
     * @return string
     */
    function purify_html($html)
    {
        if (empty($html)) {
            return '';
        }

        // Allowed tags for CMS content blocks
        $allowedTags = '<p><br><b><strong><i><u><ul><li><ol><h1><h2><h3><h4><h5><h6><a><span><div>';
        
        // Remove potentially dangerous tags and attributes
        $sanitized = strip_tags($html, $allowedTags);
        
        // Additional protection against inline event handlers and javascript: URIs
        // This is a basic filter; for enterprise-grade, an library like HTMLPurifier is recommended.
        $sanitized = preg_replace('/on\w+="[^"]*"/i', '', $sanitized);
        $sanitized = preg_replace('/javascript:[^"]*/i', '', $sanitized);

        return $sanitized;
    }
}
