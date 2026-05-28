@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Category
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
            @forelse($categories as $category)
            <tr>
                <td class="fw-semibold">{{ $category->name }}</td>
                <td style="font-family: var(--font-mono); font-size: 0.85rem; color: var(--bs-secondary-color);">{{ $category->slug }}</td>
                <td>{{ $category->articles_count }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('Delete this category?')">
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
                <td colspan="4" class="text-center text-muted py-4">No categories yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
