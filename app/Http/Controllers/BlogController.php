<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

/**
 * Контроллер блога
 */
class BlogController extends Controller
{
    /**
     * Отображение списка записей блога
     */
    public function index(Request $request)
    {
        $query = BlogPost::published();

        // Поиск
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->orderBy('published_at', 'desc')
            ->paginate(6);

        $featuredPosts = BlogPost::published()
            ->featured()
            ->limit(3)
            ->get();

        return view('blog.index', compact('posts', 'featuredPosts'));
    }

    /**
     * Отображение отдельной записи
     */
    public function show(BlogPost $post)
    {
        if (!$post->is_published || $post->published_at > now()) {
            abort(404);
        }

        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
