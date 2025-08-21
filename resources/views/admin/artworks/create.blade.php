<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать произведение - Административная панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .alert { @apply px-4 py-3 rounded-md mb-4; }
        .alert-error { @apply bg-red-100 border border-red-400 text-red-700; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.artworks.index') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к списку
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Создать произведение</h1>
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
        <!-- Ошибки валидации -->
        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.artworks.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Основная информация -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Название -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Название произведения *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Введите название произведения"
                        >
                    </div>

                    <!-- Техника -->
                    <div>
                        <label for="technique" class="block text-sm font-medium text-gray-700 mb-2">
                            Техника *
                        </label>
                        <input 
                            type="text" 
                            id="technique" 
                            name="technique" 
                            value="{{ old('technique') }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="Например: Акрил на холсте"
                        >
                    </div>

                    <!-- Год создания -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                            Год создания *
                        </label>
                        <input 
                            type="number" 
                            id="year" 
                            name="year" 
                            value="{{ old('year', date('Y')) }}"
                            min="1900"
                            max="{{ date('Y') + 1 }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Цена -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Цена (₽)
                        </label>
                        <input 
                            type="number" 
                            id="price" 
                            name="price" 
                            value="{{ old('price') }}"
                            step="0.01"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            placeholder="0.00"
                        >
                    </div>

                    <!-- Ширина -->
                    <div>
                        <label for="width" class="block text-sm font-medium text-gray-700 mb-2">
                            Ширина (см)
                        </label>
                        <input 
                            type="number" 
                            id="width" 
                            name="width" 
                            value="{{ old('width') }}"
                            step="0.1"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Высота -->
                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                            Высота (см)
                        </label>
                        <input 
                            type="number" 
                            id="height" 
                            name="height" 
                            value="{{ old('height') }}"
                            step="0.1"
                            min="0"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <!-- Описание -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Описание
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Опишите произведение, его историю, технику..."
                    >{{ old('description') }}</textarea>
                </div>

                <!-- Изображение -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Изображение произведения *
                    </label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/*"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                    <p class="text-sm text-gray-500 mt-1">Поддерживаемые форматы: JPEG, PNG, JPG, WebP. Максимальный размер: 10MB</p>
                </div>

                <!-- Категории -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Категории
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($categories as $category)
                            <label class="flex items-center space-x-2">
                                <input 
                                    type="checkbox" 
                                    name="categories[]" 
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                                >
                                <span class="text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Статусы -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            id="is_available" 
                            name="is_available" 
                            value="1"
                            {{ old('is_available', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                        >
                        <label for="is_available" class="text-sm text-gray-700">
                            Произведение доступно для показа
                        </label>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            id="is_featured" 
                            name="is_featured" 
                            value="1"
                            {{ old('is_featured') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                        >
                        <label for="is_featured" class="text-sm text-gray-700">
                            Добавить в избранные произведения
                        </label>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.artworks.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                        Отмена
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-200">
                        Создать произведение
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Предварительный просмотр изображения
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Можно добавить предварительный просмотр
                    console.log('Изображение выбрано:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>