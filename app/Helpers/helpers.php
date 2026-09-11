<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('get_content_value')) {
    /**
     * Safely extract a string value from a Spatie translatable array.
     */
    function get_content_value($value)
    {
        if (is_array($value)) {
            return $value[app()->getLocale()] ?? $value[app()->getFallbackLocale()] ?? current($value) ?? '';
        }
        return $value ?? '';
    }
}

if (!function_exists('resolve_image_url')) {
    /**
     * Resolve image URL handling different storage and asset paths.
     * Supports Cloudinary transformations.
     *
     * @param string|null $path
     * @param array $options Transformation options: w, h, q, c (crop), f (format)
     * @return string|null
     */
    function resolve_image_url($path, array $options = [])
    {
        if (empty($path)) {
            return null;
        }

        if (is_array($path)) {
            $path = $path[app()->getLocale()] ?? $path[app()->getFallbackLocale()] ?? current($path);
        }
        
        if (empty($path)) {
            return null;
        }

        $url = $path;

        // Clean up leading slash if it's not a full URL
        if (str_starts_with($path, '/') && !str_starts_with($path, '//')) {
            $path = ltrim($path, '/');
        }

        // If it's already a full URL
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            $url = $path;
        } elseif (str_starts_with($path, 'assets/')) {
            $url = asset($path);
        } elseif (!str_contains($path, '/') && !str_contains($path, '\\')) {
            // Deterministic default for flat names
            $url = asset('storage/' . $path);
        } else {
            // Standard storage paths
            if (str_starts_with($path, 'storage/')) {
                $path = substr($path, 8);
            }

            if (config('filesystems.default') === 'cloudinary') {
                $url = Storage::disk('cloudinary')->url($path);
            } else {
                $url = asset('storage/' . $path);
            }
        }

        // Apply Cloudinary transformations if applicable
        if (str_contains($url, 'res.cloudinary.com') && !empty($options)) {
            $transformations = [];
            if (isset($options['w'])) $transformations[] = "w_{$options['w']}";
            if (isset($options['h'])) $transformations[] = "h_{$options['h']}";
            if (isset($options['c'])) $transformations[] = "c_{$options['c']}";
            if (isset($options['q'])) $transformations[] = "q_{$options['q']}";
            else $transformations[] = "q_auto";
            if (isset($options['f'])) $transformations[] = "f_{$options['f']}";
            else $transformations[] = "f_auto";

            $transformationString = implode(',', $transformations);
            
            // Insert transformation after /upload/
            if (str_contains($url, '/upload/')) {
                $url = str_replace('/upload/', "/upload/{$transformationString}/", $url);
            }
        }

        return $url;
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

        // Allowed tags: basic formatting, lists, headings, links, spans, divs
        $allowedTags = '<p><br><b><strong><i><u><ul><li><ol><h1><h2><h3><h4><h5><h6><a><span><div>';
        $html = strip_tags($html, $allowedTags);

        // Native DOMDocument sanitizer as fallback for enterprise protection
        $dom = new \DOMDocument();
        // Suppress warnings from malformed HTML
        libxml_use_internal_errors(true);
        // Load with UTF-8 encoding wrapper
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        // Remove dangerous tags (though strip_tags should have caught them, just in case)
        $dangerousTags = ['script', 'iframe', 'object', 'embed', 'style', 'link', 'meta', 'applet'];
        foreach ($dangerousTags as $tag) {
            $nodes = $xpath->query("//$tag");
            foreach ($nodes as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        // Remove dangerous attributes
        $nodes = $xpath->query('//*[@*]');
        foreach ($nodes as $node) {
            $attributesToRemove = [];
            foreach ($node->attributes as $attr) {
                $name = strtolower($attr->name);
                $value = strtolower(trim($attr->value));

                // Remove inline event handlers (on*)
                if (str_starts_with($name, 'on')) {
                    $attributesToRemove[] = $attr->name;
                }
                // Remove javascript: URIs (in href, src, etc.)
                elseif (str_starts_with($value, 'javascript:')) {
                    $attributesToRemove[] = $attr->name;
                }
                // Remove vbscript: URIs
                elseif (str_starts_with($value, 'vbscript:')) {
                    $attributesToRemove[] = $attr->name;
                }
                // Remove data: URIs in href (allows phishing/XSS)
                elseif ($name === 'href' && str_starts_with($value, 'data:')) {
                    $attributesToRemove[] = $attr->name;
                }
            }
            foreach ($attributesToRemove as $attrName) {
                $node->removeAttribute($attrName);
            }
        }

        $sanitized = $dom->saveHTML();
        
        // Remove the XML declaration we added
        $sanitized = str_replace('<?xml encoding="utf-8" ?>', '', $sanitized);
        
        $sanitized = trim($sanitized);
        
        // If the original input had no HTML tags, strip the auto-added <p> wrapper
        if ($html === strip_tags($html)) {
            $sanitized = strip_tags($sanitized);
        }
        
        return $sanitized;
    }
}
