@extends('layouts.admin')

@section('title', 'Tags')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">Tags</h2>
    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Tag
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Articles</th>
                <th width="100">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tags as $tag)
            <tr>
                <td class="fw-semibold">{{ $tag->name }}</td>
                <td style="font-family: var(--font-mono); font-size: 0.85rem; color: var(--bs-secondary-color);">{{ $tag->slug }}</td>
                <td>{{ $tag->articles_count }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}"
                              onsubmit="return confirm('Delete this tag?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">No tags yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
