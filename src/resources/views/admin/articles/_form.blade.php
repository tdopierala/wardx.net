<div class="row">
    <div class="col-lg-9">
        <div class="mb-3">
            <label for="title" class="form-label" style="font-family: var(--font-mono);">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror"
                   id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="excerpt" class="form-label" style="font-family: var(--font-mono);">Excerpt</label>
            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                      id="excerpt" name="excerpt" rows="2">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            @error('excerpt')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body_markdown" class="form-label" style="font-family: var(--font-mono);">Content (Markdown)</label>
            <textarea class="form-control @error('body_markdown') is-invalid @enderror"
                      id="body_markdown" name="body_markdown">{{ old('body_markdown', $article->body_markdown ?? '') }}</textarea>
            @error('body_markdown')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-lg-3">
        <div class="mb-3">
            <label for="status" class="form-label" style="font-family: var(--font-mono);">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="draft" {{ old('status', $article->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $article->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label" style="font-family: var(--font-mono);">Category</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">-- None --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $article->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" style="font-family: var(--font-mono);">Tags</label>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tags[]"
                           value="{{ $tag->id }}" id="tag-{{ $tag->id }}"
                           {{ in_array($tag->id, old('tags', $selectedTags ?? [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="featured_image" class="form-label" style="font-family: var(--font-mono);">Featured Image</label>
            @if(isset($article) && $article->featured_image)
                <div class="mb-2">
                    <img src="{{ Storage::url($article->featured_image) }}" class="img-fluid rounded" alt="Featured">
                </div>
            @endif
            <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                   id="featured_image" name="featured_image" accept="image/*">
            @error('featured_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" style="font-family: var(--font-mono);">
            <i class="bi bi-check-lg"></i> {{ isset($article) ? 'Update' : 'Create' }} Article
        </button>
    </div>
</div>
