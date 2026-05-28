{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>wardx.net</title>
        <description>Tech blog about coding, AI, and new technologies</description>
        <link>{{ url('/') }}</link>
        <atom:link href="{{ route('feed') }}" rel="self" type="application/rss+xml"/>
        <language>en</language>
        <lastBuildDate>{{ $articles->first()?->published_at?->toRfc2822String() }}</lastBuildDate>
        @foreach($articles as $article)
        <item>
            <title>{{ htmlspecialchars($article->title) }}</title>
            <link>{{ route('article.show', $article) }}</link>
            <guid isPermaLink="true">{{ route('article.show', $article) }}</guid>
            <description>{{ htmlspecialchars($article->excerpt ?? '') }}</description>
            <pubDate>{{ $article->published_at->toRfc2822String() }}</pubDate>
            @if($article->category)
            <category>{{ htmlspecialchars($article->category->name) }}</category>
            @endif
        </item>
        @endforeach
    </channel>
</rss>
