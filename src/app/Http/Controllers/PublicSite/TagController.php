<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $articles = $tag->articles()
            ->published()
            ->with(['category', 'tags'])
            ->paginate(12);

        return view('public.tag', compact('tag', 'articles'));
    }
}
