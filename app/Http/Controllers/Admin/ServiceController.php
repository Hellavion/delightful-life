<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Административный контроллер управления услугами
 */
class ServiceController extends Controller
{
    /**
     * Отображение списка услуг в админ-панели
     */
    public function index()
    {
        $services = Service::withCount('orders')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Форма создания новой услуги
     */
    public function create()
    {
        $pricingTypes = [
            'fixed' => 'Фиксированная цена',
            'range' => 'Диапазон цен',
            'custom' => 'Индивидуально',
        ];

        return view('admin.services.create', compact('pricingTypes'));
    }

    /**
     * Сохранение новой услуги
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'description' => 'required|string',
            'process_description' => 'nullable|string',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'pricing_type' => 'required|in:fixed,range,custom',
            'duration' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'is_active' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Генерация slug если не указан
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Проверка уникальности сгенерированного slug
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Service::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        // Фильтрация пустых элементов массива features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features'], function ($feature) {
                return $feature !== null && ! empty(trim($feature));
            });
            // Если массив features пустой после фильтрации, устанавливаем null
            if (empty($validated['features'])) {
                $validated['features'] = null;
            }
        }

        // Установка значений по умолчанию
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $service = Service::create($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга "'.$service->name.'" успешно создана.');
    }

    /**
     * Отображение детальной информации об услуге
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Форма редактирования услуги
     */
    public function edit(Service $service)
    {
        $pricingTypes = [
            'fixed' => 'Фиксированная цена',
            'range' => 'Диапазон цен',
            'custom' => 'Индивидуально',
        ];

        return view('admin.services.edit', compact('service', 'pricingTypes'));
    }

    /**
     * Обновление услуги
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($service->id),
            ],
            'description' => 'required|string',
            'process_description' => 'nullable|string',
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'pricing_type' => 'required|in:fixed,range,custom',
            'duration' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'is_active' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // Генерация slug если не указан
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Проверка уникальности сгенерированного slug (исключая текущую запись)
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Service::where('slug', $validated['slug'])->where('id', '!=', $service->id)->exists()) {
            $validated['slug'] = $originalSlug.'-'.$counter;
            $counter++;
        }

        // Фильтрация пустых элементов массива features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features'], function ($feature) {
                return $feature !== null && ! empty(trim($feature));
            });
            // Если массив features пустой после фильтрации, устанавливаем null
            if (empty($validated['features'])) {
                $validated['features'] = null;
            }
        }

        // Установка значений по умолчанию
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга "'.$service->name.'" успешно обновлена.');
    }

    /**
     * Удаление услуги
     */
    public function destroy(Service $service)
    {
        $serviceName = $service->name;

        // Проверяем, есть ли связанные заказы
        if ($service->orders()->exists()) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Невозможно удалить услугу "'.$serviceName.'", так как с ней связаны заказы.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Услуга "'.$serviceName.'" успешно удалена.');
    }

    /**
     * Переключение статуса активности услуги
     */
    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => ! $service->is_active]);

        $status = $service->is_active ? 'активирована' : 'деактивирована';

        return redirect()->back()
            ->with('success', 'Услуга "'.$service->name.'" '.$status.'.');
    }

    /**
     * Массовое изменение порядка сортировки
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->services as $serviceData) {
            Service::where('id', $serviceData['id'])
                ->update(['sort_order' => $serviceData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
