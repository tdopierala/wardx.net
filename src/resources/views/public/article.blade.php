@extends('layouts.public')

@section('title', $article->title)
@section('meta_description', $article->excerpt)

@section('meta')
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:description" content="{{ $article->excerpt }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('article.show', $article) }}">
@if($article->featured_image)
<meta property="og:image" content="{{ Storage::url($article->featured_image) }}">
@endif
<meta property="article:published_time" content="{{ $article->published_at->toIso8601String() }}">
@if($article->category)
<meta property="article:section" content="{{ $article->category->name }}">
@endif
@foreach($article->tags as $tag)
<meta property="article:tag" content="{{ $tag->name }}">
@endforeach
@endsection

@section('content')
<article class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="font-family: var(--font-mono); font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">~/home</a></li>
                    @if($article->category)
                        <li class="breadcrumb-item">
                            <a href="{{ route('category.show', $article->category) }}" class="text-decoration-none">
                                {{ $article->category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active">{{ Str::limit($article->title, 40) }}</li>
                </ol>
            </nav>

            <header class="mb-4">
                <h1 class="mb-3" style="font-weight: 700;">{{ $article->title }}</h1>

                <div class="d-flex flex-wrap align-items-center gap-3 text-muted mb-3">
                    <span class="reading-time">
                        <i class="bi bi-calendar3"></i> {{ $article->published_at->format('F d, Y') }}
                    </span>
                    <span class="reading-time">
                        <i class="bi bi-clock"></i> {{ $article->reading_time }} min read
                    </span>
                    @if($article->category)
                        <a href="{{ route('category.show', $article->category) }}" class="badge-tag">
                            {{ $article->category->name }}
                        </a>
                    @endif
                </div>

                @if($article->excerpt)
                    <p class="lead text-muted" style="border-left: 3px solid var(--accent); padding-left: 1rem;">
                        {{ $article->excerpt }}
                    </p>
                @endif
            </header>

            @if($article->featured_image)
                <div class="mb-4">
                    <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                         class="img-fluid rounded" style="width: 100%; border: 1px solid var(--border-color);">
                </div>
            @endif

            <div class="article-content">
                {!! $article->body_html !!}
            </div>

            <div class="mt-4 pt-4" style="border-top: 1px solid var(--border-color);">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag) }}" class="badge-tag">
                            <i class="bi bi-hash"></i>{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <nav class="mt-5 pt-4" style="border-top: 1px solid var(--border-color);">
                <div class="row">
                    <div class="col-6">
                        @if($prevArticle)
                            <small class="reading-time d-block mb-1">Previous</small>
                            <a href="{{ route('article.show', $prevArticle) }}" class="text-decoration-none">
                                <i class="bi bi-arrow-left"></i> {{ Str::limit($prevArticle->title, 40) }}
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        @if($nextArticle)
                            <small class="reading-time d-block mb-1">Next</small>
                            <a href="{{ route('article.show', $nextArticle) }}" class="text-decoration-none">
                                {{ Str::limit($nextArticle->title, 40) }} <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </nav>

            @if($relatedArticles->count() > 0)
            <section class="mt-5 pt-4" style="border-top: 1px solid var(--border-color);">
                <h4 style="font-family: var(--font-mono); color: var(--accent);">// related posts</h4>
                <div class="row g-3 mt-2">
                    @foreach($relatedArticles as $related)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ route('article.show', $related) }}">{{ $related->title }}</a>
                                </h6>
                                <span class="reading-time">{{ $related->reading_time }} min read</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>
    </div>
</article>
@endsection
