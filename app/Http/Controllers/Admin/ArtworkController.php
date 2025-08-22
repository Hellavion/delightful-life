<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Контроллер для управления произведениями искусства в административной панели
 */
class ArtworkController extends Controller
{
    /**
     * Отобразить список всех произведений
     */
    public function index(Request $request): View
    {
        $query = Artwork::with('categories');

        // Фильтрация по категории
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Поиск по названию
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->search.'%');
        }

        $artworks = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('admin.artworks.index', compact('artworks', 'categories'));
    }

    /**
     * Показать форму для создания нового произведения
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.artworks.create', compact('categories'));
    }

    /**
     * Сохранить новое произведение в базе данных
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'technique' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Обработка checkbox'ов отдельно
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Генерация slug
        $validated['slug'] = Str::slug($validated['title']).'-'.Str::random(6);

        // Загрузка изображения
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork = Artwork::create($validated);

        // Привязка категорий
        if (isset($validated['categories'])) {
            $artwork->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Произведение успешно создано!');
    }

    /**
     * Показать детали произведения
     */
    public function show(Artwork $artwork): View
    {
        $artwork->load('categories');

        return view('admin.artworks.show', compact('artwork'));
    }

    /**
     * Показать форму для редактирования произведения
     */
    public function edit(Artwork $artwork): View
    {
        $categories = Category::all();
        $artwork->load('categories');

        return view('admin.artworks.edit', compact('artwork', 'categories'));
    }

    /**
     * Обновить произведение в базе данных
     */
    public function update(Request $request, Artwork $artwork): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'technique' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        // Обработка checkbox'ов отдельно
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        // Обновление slug если изменился title
        if ($artwork->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']).'-'.Str::random(6);
        }

        // Загрузка нового изображения
        if ($request->hasFile('image')) {
            // Удаление старого изображения
            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update($validated);

        // Обновление категорий
        if (isset($validated['categories'])) {
            $artwork->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Произведение успешно обновлено!');
    }

    /**
     * Удалить произведение из базы данных
     */
    public function destroy(Artwork $artwork): RedirectResponse
    {
        // Удаление изображения
        if ($artwork->image_path) {
            Storage::disk('public')->delete($artwork->image_path);
        }

        $artwork->delete();

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Произведение успешно удалено!');
    }

    /**
     * Переключить статус избранного произведения
     */
    public function toggleFeatured(Artwork $artwork): RedirectResponse
    {
        $newStatus = ! $artwork->is_featured;
        $artwork->update(['is_featured' => $newStatus]);
        $artwork->refresh(); // Принудительно обновляем модель из БД

        $status = $newStatus ? 'добавлено в избранные' : 'убрано из избранных';

        return redirect()->route('admin.artworks.index')
            ->with('success', "Произведение {$status}!");
    }

    /**
     * Переключить статус доступности произведения
     */
    public function toggleAvailability(Artwork $artwork): RedirectResponse
    {
        $newStatus = ! $artwork->is_available;
        $artwork->update(['is_available' => $newStatus]);
        $artwork->refresh(); // Принудительно обновляем модель из БД

        $status = $newStatus ? 'помечено как доступное' : 'помечено как недоступное';

        return redirect()->route('admin.artworks.index')
            ->with('success', "Произведение {$status}!");
    }
}
