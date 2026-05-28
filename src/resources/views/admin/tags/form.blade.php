@extends('layouts.admin')

@section('title', isset($tag) ? 'Edit Tag' : 'New Tag')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-family: var(--font-mono);">{{ isset($tag) ? 'Edit' : 'New' }} Tag</h2>
    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <form method="POST"
              action="{{ isset($tag) ? route('admin.tags.update', $tag) : route('admin.tags.store') }}">
            @csrf
            @if(isset($tag))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label" style="font-family: var(--font-mono);">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name', $tag->name ?? '') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="font-family: var(--font-mono);">
                <i class="bi bi-check-lg"></i> {{ isset($tag) ? 'Update' : 'Create' }}
            </button>
        </form>
    </div>
</div>
@endsection
