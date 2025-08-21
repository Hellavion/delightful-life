<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artwork->title }} - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
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
                    <h1 class="text-xl font-semibold text-gray-900">{{ $artwork->title }}</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.artworks.edit', $artwork) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition duration-200">
                        Редактировать
                    </a>
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

    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                <!-- Изображение -->
                <div>
                    @if($artwork->image_path)
                        <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-auto rounded-lg shadow-md">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-lg">Нет изображения</span>
                        </div>
                    @endif
                </div>

                <!-- Информация -->
                <div class="space-y-6">
                    <!-- Основная информация -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $artwork->title }}</h2>
                        
                        <!-- Статусы -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($artwork->is_featured)
                                <span class="inline-block bg-yellow-500 text-white text-sm px-3 py-1 rounded">Избранное</span>
                            @endif
                            @if($artwork->is_available)
                                <span class="inline-block bg-green-500 text-white text-sm px-3 py-1 rounded">Доступно</span>
                            @else
                                <span class="inline-block bg-red-500 text-white text-sm px-3 py-1 rounded">Недоступно</span>
                            @endif
                        </div>

                        <!-- Категории -->
                        @if($artwork->categories->count() > 0)
                            <div class="mb-4">
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Категории:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($artwork->categories as $category)
                                        <span class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Детали -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Техника</h3>
                            <p class="text-gray-900">{{ $artwork->technique }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Год создания</h3>
                            <p class="text-gray-900">{{ $artwork->year }}</p>
                        </div>
                        @if($artwork->width && $artwork->height)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Размеры</h3>
                                <p class="text-gray-900">{{ $artwork->width }} × {{ $artwork->height }} см</p>
                            </div>
                        @endif
                        @if($artwork->price)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Цена</h3>
                                <p class="text-gray-900">{{ number_format($artwork->price, 0, ',', ' ') }} ₽</p>
                            </div>
                        @endif
                    </div>

                    <!-- Описание -->
                    @if($artwork->description)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Описание</h3>
                            <p class="text-gray-900 leading-relaxed">{{ $artwork->description }}</p>
                        </div>
                    @endif

                    <!-- Технические данные -->
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Технические данные</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Slug:</span>
                                <span class="text-gray-900">{{ $artwork->slug }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">ID:</span>
                                <span class="text-gray-900">#{{ $artwork->id }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Создано:</span>
                                <span class="text-gray-900">{{ $artwork->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Обновлено:</span>
                                <span class="text-gray-900">{{ $artwork->updated_at->format('d.m.Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Быстрые действия -->
                    <div class="pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Быстрые действия</h3>
                        <div class="flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('admin.artworks.toggle-featured', $artwork) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $artwork->is_featured ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white px-4 py-2 rounded-md transition duration-200">
                                    {{ $artwork->is_featured ? 'Убрать из избранных' : 'В избранное' }}
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('admin.artworks.toggle-availability', $artwork) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="{{ $artwork->is_available ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-md transition duration-200">
                                    {{ $artwork->is_available ? 'Скрыть' : 'Показать' }}
                                </button>
                            </form>

                            <a href="{{ route('portfolio.show', $artwork->slug) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                                Посмотреть на сайте
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>