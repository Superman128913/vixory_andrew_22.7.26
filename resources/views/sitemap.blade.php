<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/about</loc>
        <changefreq>yearly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/faq</loc>
        <changefreq>yearly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/blog</loc>
        <changefreq>yearly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/registration</loc>
        <changefreq>yearly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/terms-of-use</loc>
        <changefreq>yearly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/fulfillment-policy</loc>
        <changefreq>yearly</changefreq>
        <priority>0.8</priority>
    </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ url('/') }}/blog/{{ rawurlencode($post->title) }}</loc>
            <changefreq>yearly</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>