<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

/**
 * Контроллер новостей
 */
class NewsController extends Controller
{
    /**
     * Отображение списка новостей
     */
    public function index(Request $request)
    {
        $query = News::published();

        // Поиск
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('excerpt', 'like', '%'.$request->search.'%')
                    ->orWhere('content', 'like', '%'.$request->search.'%');
            });
        }

        $posts = $query->orderBy('published_at', 'desc')
            ->paginate(6);

        $featuredPosts = News::published()
            ->featured()
            ->limit(3)
            ->get();

        return view('news.index', compact('posts', 'featuredPosts'));
    }

    /**
     * Отображение отдельной новости
     */
    public function show(News $post)
    {
        if (! $post->is_published || $post->published_at > now()) {
            abort(404);
        }

        $relatedPosts = News::published()
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('news.show', compact('post', 'relatedPosts'));
    }
}
