<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Pages -->
    <url>
        <loc>{{ $frontendUrl }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ $frontendUrl }}/about</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ $frontendUrl }}/services</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ $frontendUrl }}/projects</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ $frontendUrl }}/blog</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ $frontendUrl }}/contact</loc>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>

    <!-- Services -->
    @foreach ($services as $service)
    <url>
        <loc>{{ $frontendUrl }}/services/{{ $service->slug }}</loc>
        <lastmod>{{ $service->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    <!-- Projects -->
    @foreach ($projects as $project)
    <url>
        <loc>{{ $frontendUrl }}/projects/{{ $project->slug }}</loc>
        <lastmod>{{ $project->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    <!-- Blogs -->
    @foreach ($blogs as $blog)
    <url>
        <loc>{{ $frontendUrl }}/blog/{{ $blog->slug }}</loc>
        <lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>
