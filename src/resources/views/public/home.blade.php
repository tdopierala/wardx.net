@extends('layouts.public')

@section('title', 'Home')

@section('content')
@if($featuredArticle)
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="mb-2">
                    @if($featuredArticle->category)
                        <a href="{{ route('category.show', $featuredArticle->category) }}" class="badge-tag text-decoration-none">
                            {{ $featuredArticle->category->name }}
                        </a>
                    @endif
                    <span class="reading-time ms-2">
                        <i class="bi bi-clock"></i> {{ $featuredArticle->reading_time }} min read
                    </span>
                </div>
                <h1 class="mb-3">
                    <a href="{{ route('article.show', $featuredArticle) }}" class="text-decoration-none" style="color: var(--bs-body-color);">
                        {{ $featuredArticle->title }}
                    </a>
                </h1>
                <p class="lead text-muted">{{ $featuredArticle->excerpt }}</p>
                <div class="mt-3">
                    @foreach($featuredArticle->tags as $tag)
                        <a href="{{ route('tag.show', $tag) }}" class="badge-tag me-1">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <p class="reading-time mt-3">
                    <i class="bi bi-calendar3"></i> {{ $featuredArticle->published_at->format('M d, Y') }}
                </p>
            </div>
            @if($featuredArticle->featured_image)
            <div class="col-lg-5">
                <img src="{{ Storage::url($featuredArticle->featured_image) }}" alt="{{ $featuredArticle->title }}"
                     class="img-fluid rounded" style="border: 1px solid var(--border-color);">
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="mb-4" style="font-family: var(--font-mono); color: var(--accent);">// latest posts</h4>

            <div class="row g-4">
                @forelse($articles as $article)
                <div class="col-md-6">
                    <div class="card h-100">
                        @if($article->featured_image)
                            <img src="{{ Storage::url($article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}"
                                 style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                @if($article->category)
                                    <a href="{{ route('category.show', $article->category) }}" class="badge-tag small">
                                        {{ $article->category->name }}
                                    </a>
                                @else
                                    <span></span>
                                @endif
                                <span class="reading-time">{{ $article->reading_time }} min</span>
                            </div>
                            <h5 class="card-title">
                                <a href="{{ route('article.show', $article) }}">{{ $article->title }}</a>
                            </h5>
                            <p class="card-text text-muted small">{{ Str::limit($article->excerpt, 120) }}</p>
                        </div>
                        <div class="card-footer border-0 bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @foreach($article->tags->take(3) as $tag)
                                        <a href="{{ route('tag.show', $tag) }}" class="badge-tag small me-1">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                                <small class="reading-time">{{ $article->published_at->format('M d') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-file-text" style="font-size: 3rem;"></i>
                        <p class="mt-3" style="font-family: var(--font-mono);">No articles published yet.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links() }}
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar-section mb-4">
                <h5 class="mb-3">Categories</h5>
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <a href="{{ route('category.show', $category) }}"
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                           style="background: transparent; border-color: var(--border-color);">
                            {{ $category->name }}
                            <span class="badge bg-secondary rounded-pill">{{ $category->articles_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="sidebar-section">
                <h5 class="mb-3">Tags</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <a href="{{ route('tag.show', $tag) }}" class="badge-tag">
                            {{ $tag->name }} ({{ $tag->articles_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
