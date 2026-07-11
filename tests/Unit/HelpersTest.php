<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class HelpersTest extends TestCase
{
    /**
     * Test purify_html() handling of XSS and allowed tags.
     */
    public function test_purify_html_removes_xss_but_keeps_allowed_tags()
    {
        $safeHtml = "<p>This is <strong>safe</strong> and <a href=\"/link\">good</a>.</p>";
        $this->assertEquals($safeHtml, purify_html($safeHtml));

        $xssHtml = "<p>Text <script>alert('xss');</script> and <a href=\"javascript:alert(1)\">click</a>.</p>";
        // script tag removed, href with javascript removed
        $purified = purify_html($xssHtml);
        
        $this->assertStringNotContainsString('<script>', $purified);
        $this->assertStringNotContainsString('javascript:alert', $purified);
        $this->assertStringContainsString('<p>Text alert(\'xss\'); and <a>click</a>.</p>', $purified);

        // Test on* event handlers
        $eventHtml = "<div onclick=\"bad()\" onmouseover=\"worse()\">Hover me</div>";
        $this->assertEquals("<div>Hover me</div>", purify_html($eventHtml));

        // Test data URIs
        $dataUriHtml = "<a href=\"data:text/html,<script>alert(1)</script>\">Data</a>";
        $this->assertEquals("<a>Data</a>", purify_html($dataUriHtml));
    }

    /**
     * Test resolve_image_url() resolution logic.
     */
    public function test_resolve_image_url()
    {
        // 1. Empty path
        $this->assertNull(resolve_image_url(''));

        // 2. Full URL
        $this->assertEquals('https://example.com/img.jpg', resolve_image_url('https://example.com/img.jpg'));

        // 3. Flat name (deterministic storage path)
        $this->assertEquals(asset('storage/image.jpg'), resolve_image_url('image.jpg'));

        // 4. assets path
        $this->assertEquals(asset('assets/img/logo.png'), resolve_image_url('assets/img/logo.png'));

        // 5. standard storage path
        $this->assertEquals(asset('storage/uploads/file.png'), resolve_image_url('storage/uploads/file.png'));
        
        // 6. Cloudinary active config
        Config::set('filesystems.default', 'cloudinary');
        Storage::extend('cloudinary', function ($app, $config) {
            return Storage::createLocalDriver(['root' => 'dummy']); 
            // We just need a driver that doesn't crash to test url() call if possible.
            // Actually, testing cloudinary directly without the real driver registered might fail the url() call.
            // Let's test the cloudinary transformations on a fake res.cloudinary.com URL instead.
        });
        
        $cloudUrl = 'https://res.cloudinary.com/demo/image/upload/v1234/sample.jpg';
        $transformed = resolve_image_url($cloudUrl, ['w' => 100, 'h' => 200]);
        $this->assertStringContainsString('/upload/w_100,h_200,q_auto,f_auto/', $transformed);
    }
}
