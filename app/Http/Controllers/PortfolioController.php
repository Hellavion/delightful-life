<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * Контроллер портфолио
 */
class PortfolioController extends Controller
{
    /**
     * Отображение списка произведений
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = Artwork::query();

        // Фильтрация по категории
        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Поиск
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%')
                    ->orWhere('medium', 'like', '%'.$request->search.'%');
            });
        }

        $artworks = $query->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('portfolio.index', compact('artworks', 'categories'));
    }

    /**
     * Отображение отдельного произведения
     */
    public function show(Artwork $artwork)
    {
        $relatedArtworks = Artwork::whereHas('categories', function ($query) use ($artwork) {
            $query->whereIn('categories.id', $artwork->categories->pluck('id'));
        })
            ->where('id', '!=', $artwork->id)
            ->limit(4)
            ->get();

        return view('portfolio.show', compact('artwork', 'relatedArtworks'));
    }
}
