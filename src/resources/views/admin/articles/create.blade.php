@extends('layouts.admin')

@section('title', 'Create Article')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">New Article</h2>
    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.articles._form')
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
    const easyMDE = new EasyMDE({
        element: document.getElementById('body_markdown'),
        spellChecker: false,
        autosave: { enabled: true, uniqueId: 'article-create', delay: 5000 },
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
