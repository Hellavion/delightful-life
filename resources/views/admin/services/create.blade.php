<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание услуги - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.services.index') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к списку услуг
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Создание услуги</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">{{ Auth::guard('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200">
                            Выйти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-6 p-6">
                @csrf

                <!-- Основная информация -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Основная информация</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Название -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Название услуги *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="md:col-span-2">
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                URL-адрес (slug)
                                <small class="text-gray-500">Оставьте пустым для автоматической генерации</small>
                            </label>
                            <input type="text" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('slug') border-red-500 @enderror">
                            @error('slug')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Описание -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Описание</h3>
                    
                    <!-- Основное описание -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Описание услуги *
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Описание процесса работы -->
                    <div>
                        <label for="process_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Описание процесса работы
                            <small class="text-gray-500">Как происходит работа над заказом</small>
                        </label>
                        <textarea id="process_description" 
                                  name="process_description" 
                                  rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('process_description') border-red-500 @enderror">{{ old('process_description') }}</textarea>
                        @error('process_description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Ценообразование -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ценообразование</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Тип ценообразования -->
                        <div class="md:col-span-3">
                            <label for="pricing_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Тип ценообразования *
                            </label>
                            <select id="pricing_type" 
                                    name="pricing_type" 
                                    required
                                    onchange="togglePriceFields()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('pricing_type') border-red-500 @enderror">
                                @foreach($pricingTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('pricing_type') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pricing_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Цена от -->
                        <div id="price_from_field">
                            <label for="price_from" class="block text-sm font-medium text-gray-700 mb-2">
                                Цена от (₽)
                            </label>
                            <input type="number" 
                                   id="price_from" 
                                   name="price_from" 
                                   value="{{ old('price_from') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price_from') border-red-500 @enderror">
                            @error('price_from')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Цена до -->
                        <div id="price_to_field" style="display: none;">
                            <label for="price_to" class="block text-sm font-medium text-gray-700 mb-2">
                                Цена до (₽)
                            </label>
                            <input type="number" 
                                   id="price_to" 
                                   name="price_to" 
                                   value="{{ old('price_to') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price_to') border-red-500 @enderror">
                            @error('price_to')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Длительность -->
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Примерные сроки
                                <small class="text-gray-500">Например: "3-5 дней", "1-2 недели"</small>
                            </label>
                            <input type="text" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('duration') border-red-500 @enderror">
                            @error('duration')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Особенности услуги -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Что включено в услугу</h3>
                    
                    <div id="features-container">
                        <div class="space-y-3" id="features-list">
                            @if(old('features'))
                                @foreach(old('features') as $index => $feature)
                                    <div class="flex items-center space-x-2 feature-item">
                                        <input type="text" 
                                               name="features[]" 
                                               value="{{ $feature }}"
                                               placeholder="Описание особенности услуги"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <button type="button" 
                                                onclick="removeFeature(this)"
                                                class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="flex items-center space-x-2 feature-item">
                                    <input type="text" 
                                           name="features[]" 
                                           placeholder="Описание особенности услуги"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <button type="button" 
                                            onclick="removeFeature(this)"
                                            class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                        <button type="button" 
                                onclick="addFeature()"
                                class="mt-3 text-green-600 hover:text-green-800 text-sm">
                            + Добавить особенность
                        </button>
                    </div>
                </div>

                <!-- Настройки публикации -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Настройки публикации</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Активность -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_active" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm font-medium text-gray-700">Активная услуга</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Услуга будет отображаться на сайте</p>
                        </div>

                        <!-- Порядок сортировки -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Порядок сортировки
                            </label>
                            <input type="number" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('sort_order') border-red-500 @enderror">
                            @error('sort_order')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Меньше значение = выше в списке</p>
                        </div>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.services.index') }}" 
                       class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                        Отмена
                    </a>
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-200">
                        Создать услугу
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePriceFields() {
            const pricingType = document.getElementById('pricing_type').value;
            const priceFromField = document.getElementById('price_from_field');
            const priceToField = document.getElementById('price_to_field');
            
            if (pricingType === 'custom') {
                priceFromField.style.display = 'none';
                priceToField.style.display = 'none';
            } else if (pricingType === 'range') {
                priceFromField.style.display = 'block';
                priceToField.style.display = 'block';
            } else { // fixed
                priceFromField.style.display = 'block';
                priceToField.style.display = 'none';
            }
        }

        function addFeature() {
            const featuresList = document.getElementById('features-list');
            const newFeature = document.createElement('div');
            newFeature.className = 'flex items-center space-x-2 feature-item';
            newFeature.innerHTML = `
                <input type="text" 
                       name="features[]" 
                       placeholder="Описание особенности услуги"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <button type="button" 
                        onclick="removeFeature(this)"
                        class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            featuresList.appendChild(newFeature);
        }

        function removeFeature(button) {
            const featuresList = document.getElementById('features-list');
            if (featuresList.children.length > 1) {
                button.closest('.feature-item').remove();
            }
        }

        // Инициализация при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            togglePriceFields();
        });
    </script>
</body>
</html>