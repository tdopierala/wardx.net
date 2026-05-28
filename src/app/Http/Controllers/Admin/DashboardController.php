<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'published' => Article::published()->count(),
            'drafts' => Article::draft()->count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
        ];

        $recentArticles = Article::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }
}
