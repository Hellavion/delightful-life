<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\BlogPost;
use App\Models\Service;
use Illuminate\Http\Request;

/**
 * Контроллер главной страницы
 */
class HomeController extends Controller
{
    /**
     * Отображение главной страницы
     */
    public function index()
    {
        // Рекомендуемые работы
        $featuredArtworks = Artwork::where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        // Последние работы
        $latestArtworks = Artwork::orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Услуги
        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // Последние записи блога
        $latestPosts = BlogPost::published()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return view('home', compact(
            'featuredArtworks',
            'latestArtworks', 
            'services',
            'latestPosts'
        ));
    }
}
