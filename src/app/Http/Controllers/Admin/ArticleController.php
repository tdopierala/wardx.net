<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Services\MarkdownService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct(
        protected MarkdownService $markdown
    ) {}

    public function index()
    {
        $articles = Article::with(['category', 'tags'])
            ->latest()
            ->paginate(20);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string',
            'body_markdown' => 'required|string',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['body_html'] = $this->markdown->toHtml($validated['body_markdown']);
        $validated['reading_time'] = $this->markdown->estimateReadingTime($validated['body_markdown']);

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        $slug = $validated['slug'];
        $counter = 1;
        while (Article::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $slug . '-' . $counter++;
        }

        $article = Article::create(collect($validated)->except('tags')->toArray());

        if (!empty($validated['tags'])) {
            $article->tags()->sync($validated['tags']);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return redirect()->route('admin.articles.edit', $article);
    }

    public function edit(Article $article)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $article->tags->pluck('id')->toArray();
        return view('admin.articles.edit', compact('article', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'excerpt' => 'nullable|string',
            'body_markdown' => 'required|string',
            'status' => 'required|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['body_html'] = $this->markdown->toHtml($validated['body_markdown']);
        $validated['reading_time'] = $this->markdown->estimateReadingTime($validated['body_markdown']);

        if ($validated['status'] === 'published' && !$article->published_at) {
            $validated['published_at'] = now();
        } elseif ($validated['status'] === 'draft') {
            $validated['published_at'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        $article->update(collect($validated)->except('tags')->toArray());
        $article->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}
