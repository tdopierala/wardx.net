@extends('layouts.public')

@section('title', '#' . $tag->name)
@section('meta_description', 'Articles tagged with ' . $tag->name)

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="font-family: var(--font-mono); font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">~/home</a></li>
                <li class="breadcrumb-item active">#{{ $tag->name }}</li>
            </ol>
        </nav>
        <h1 style="font-family: var(--font-mono);">
            <span style="color: var(--accent);">#</span>{{ $tag->name }}
        </h1>
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
                            @foreach($article->tags->take(3) as $t)
                                <a href="{{ route('tag.show', $t) }}" class="badge-tag small me-1 {{ $t->id === $tag->id ? 'active' : '' }}">{{ $t->name }}</a>
                            @endforeach
                        </div>
                        <small class="reading-time">{{ $article->published_at->format('M d') }}</small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <p style="font-family: var(--font-mono);">No articles with this tag yet.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection
