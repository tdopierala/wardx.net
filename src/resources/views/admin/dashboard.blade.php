@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4" style="font-family: var(--font-mono);">Dashboard</h2>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['articles'] }}</div>
            <div class="stat-label">Total Articles</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['published'] }}</div>
            <div class="stat-label">Published</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['drafts'] }}</div>
            <div class="stat-label">Drafts</div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 style="font-family: var(--font-mono);">Recent Articles</h5>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i> New Article
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentArticles as $article)
            <tr>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-decoration-none">
                        {{ $article->title }}
                    </a>
                </td>
                <td>{{ $article->category?->name ?? '-' }}</td>
                <td>
                    <span class="badge {{ $article->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                        {{ $article->status }}
                    </span>
                </td>
                <td style="font-family: var(--font-mono); font-size: 0.8rem;">
                    {{ $article->created_at->format('Y-m-d') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">No articles yet. Create your first one!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
