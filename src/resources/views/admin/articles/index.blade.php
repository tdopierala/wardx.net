@extends('layouts.admin')

@section('title', 'Articles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">Articles</h2>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Article
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Tags</th>
                <th>Status</th>
                <th>Reading Time</th>
                <th>Date</th>
                <th width="100">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="text-decoration-none fw-semibold">
                        {{ $article->title }}
                    </a>
                </td>
                <td>{{ $article->category?->name ?? '-' }}</td>
                <td>
                    @foreach($article->tags as $tag)
                        <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>
                    <span class="badge {{ $article->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                        {{ $article->status }}
                    </span>
                </td>
                <td style="font-family: var(--font-mono); font-size: 0.8rem;">{{ $article->reading_time }} min</td>
                <td style="font-family: var(--font-mono); font-size: 0.8rem;">
                    {{ $article->created_at->format('Y-m-d') }}
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                              onsubmit="return confirm('Delete this article?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">No articles found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    {{ $articles->links() }}
</div>
@endsection
