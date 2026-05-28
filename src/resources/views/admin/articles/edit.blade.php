@extends('layouts.admin')

@section('title', 'Edit Article')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">Edit Article</h2>
    <div>
        @if($article->status === 'published')
            <a href="{{ route('article.show', $article) }}" class="btn btn-outline-info btn-sm me-2" target="_blank">
                <i class="bi bi-eye"></i> View
            </a>
        @endif
        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.articles._form')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
    const easyMDE = new EasyMDE({
        element: document.getElementById('body_markdown'),
        spellChecker: false,
        autosave: { enabled: true, uniqueId: 'article-edit-{{ $article->id }}', delay: 5000 },
        minHeight: '400px',
        status: ['lines', 'words'],
        toolbar: [
            'bold', 'italic', 'heading', '|',
            'code', 'quote', 'unordered-list', 'ordered-list', '|',
            'link', 'image', 'table', '|',
            'preview', 'side-by-side', 'fullscreen', '|',
            'guide'
        ],
    });
</script>
@endpush
