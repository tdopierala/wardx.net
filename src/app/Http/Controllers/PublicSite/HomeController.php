<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index()
    {
        $featuredArticle = Article::published()
            ->with(['category', 'tags'])
            ->first();

        $articles = Article::published()
            ->with(['category', 'tags'])
            ->when($featuredArticle, fn($q) => $q->where('id', '!=', $featuredArticle->id))
            ->paginate(9);

        $categories = Category::withCount(['articles' => fn($q) => $q->published()])->get();
        $tags = Tag::withCount(['articles' => fn($q) => $q->published()])->get();

        return view('public.home', compact('featuredArticle', 'articles', 'categories', 'tags'));
    }

    public function feed()
    {
        $articles = Article::published()
            ->with('category')
            ->take(20)
            ->get();

        return response()
            ->view('public.feed', compact('articles'))
            ->header('Content-Type', 'application/rss+xml; charset=utf-8');
    }

    public function sitemap()
    {
        $articles = Article::published()->get();
        $categories = Category::all();
        $tags = Tag::all();

        return response()
            ->view('public.sitemap', compact('articles', 'categories', 'tags'))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
