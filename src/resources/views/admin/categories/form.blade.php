@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Category' : 'New Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">{{ isset($category) ? 'Edit' : 'New' }} Category</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <form method="POST"
              action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label" style="font-family: var(--font-mono);">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label" style="font-family: var(--font-mono);">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="font-family: var(--font-mono);">
                <i class="bi bi-check-lg"></i> {{ isset($category) ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
</div>
@endsection
