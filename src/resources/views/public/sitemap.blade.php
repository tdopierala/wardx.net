{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach($articles as $article)
    <url>
        <loc>{{ route('article.show', $article) }}</loc>
        <lastmod>{{ $article->updated_at->toIso8601String() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @foreach($categories as $category)
    <url>
        <loc>{{ route('category.show', $category) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
    @foreach($tags as $tag)
    <url>
        <loc>{{ route('tag.show', $tag) }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    @endforeach
</urlset>
