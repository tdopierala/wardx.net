<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        if ($article->status !== 'published') {
            abort(404);
        }

        $article->load(['category', 'tags']);

        $prevArticle = Article::published()
            ->where('published_at', '<', $article->published_at)
            ->first();

        $nextArticle = Article::published()
            ->where('published_at', '>', $article->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        return view('public.article', compact('article', 'prevArticle', 'nextArticle', 'relatedArticles'));
    }
}
