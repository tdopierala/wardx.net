@extends('layouts.public')

@section('title', $category->name)
@section('meta_description', $category->description ?? 'Articles in ' . $category->name)

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="font-family: var(--font-mono); font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">~/home</a></li>
                <li class="breadcrumb-item active">{{ $category->name }}</li>
            </ol>
        </nav>
        <h1 style="font-family: var(--font-mono);">
            <span style="color: var(--accent);">//</span> {{ $category->name }}
        </h1>
        @if($category->description)
            <p class="text-muted lead">{{ $category->description }}</p>
        @endif
    </div>

    <div class="row g-4">
        @forelse($articles as $article)
        <div class="col-md-4">
            <div class="card h-100">
                @if($article->featured_image)
                    <img src="{{ Storage::url($article->featured_image) }}" class="card-img-top" alt="{{ $article->title }}"
                         style="height: 180px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="reading-time">{{ $article->reading_time }} min read</span>
                        <span class="reading-time">{{ $article->published_at->format('M d') }}</span>
                    </div>
                    <h5 class="card-title">
                        <a href="{{ route('article.show', $article) }}">{{ $article->title }}</a>
                    </h5>
                    <p class="card-text text-muted small">{{ Str::limit($article->excerpt, 120) }}</p>
                </div>
                <div class="card-footer border-0 bg-transparent">
                    @foreach($article->tags->take(3) as $tag)
                        <a href="{{ route('tag.show', $tag) }}" class="badge-tag small me-1">{{ $tag->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <p style="font-family: var(--font-mono);">No articles in this category yet.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection
