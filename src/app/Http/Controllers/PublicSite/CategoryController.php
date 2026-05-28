<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $articles = $category->articles()
            ->published()
            ->with('tags')
            ->paginate(12);

        return view('public.category', compact('category', 'articles'));
    }
}
