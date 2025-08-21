<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление портфолио - Административная панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .alert { @apply px-4 py-3 rounded-md mb-4; }
        .alert-success { @apply bg-green-100 border border-green-400 text-green-700; }
        .alert-error { @apply bg-red-100 border border-red-400 text-red-700; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к дашборду
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Управление портфолио</h1>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Уведомления -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Фильтры и поиск -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex flex-col md:flex-row gap-4 flex-1">
                    <form method="GET" class="flex flex-col md:flex-row gap-4 flex-1">
                        <!-- Поиск -->
                        <div class="flex-1">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Поиск по названию..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Фильтр по категории -->
                        <div class="md:w-48">
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Все категории</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                            Найти
                        </button>

                        @if(request()->hasAny(['search', 'category']))
                            <a href="{{ route('admin.artworks.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                                Сбросить
                            </a>
                        @endif
                    </form>
                </div>

                <a href="{{ route('admin.artworks.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                    Добавить произведение
                </a>
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Всего произведений</div>
                <div class="text-2xl font-bold text-gray-900">{{ $artworks->total() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Избранные</div>
                <div class="text-2xl font-bold text-green-600">{{ $artworks->where('is_featured', true)->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Доступные</div>
                <div class="text-2xl font-bold text-blue-600">{{ $artworks->where('is_available', true)->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Категории</div>
                <div class="text-2xl font-bold text-purple-600">{{ $categories->count() }}</div>
            </div>
        </div>

        <!-- Список произведений -->
        <div class="bg-white rounded-lg shadow">
            @if($artworks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                    @foreach($artworks as $artwork)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition duration-200">
                            <!-- Изображение -->
                            <div class="aspect-square bg-gray-200 relative">
                                @if($artwork->image_path)
                                    <img src="{{ Storage::url($artwork->image_path) }}" alt="{{ $artwork->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        Нет изображения
                                    </div>
                                @endif
                                
                                <!-- Статусы -->
                                <div class="absolute top-2 left-2 space-y-1">
                                    @if($artwork->is_featured)
                                        <span class="inline-block bg-yellow-500 text-white text-xs px-2 py-1 rounded">Избранное</span>
                                    @endif
                                    @if(!$artwork->is_available)
                                        <span class="inline-block bg-red-500 text-white text-xs px-2 py-1 rounded">Недоступно</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Информация -->
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 truncate">{{ $artwork->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $artwork->technique }} • {{ $artwork->year }}</p>
                                
                                @if($artwork->categories->count() > 0)
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @foreach($artwork->categories as $category)
                                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Действия -->
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.artworks.show', $artwork) }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded text-sm hover:bg-blue-700 transition duration-200">
                                        Просмотр
                                    </a>
                                    <a href="{{ route('admin.artworks.edit', $artwork) }}" class="flex-1 bg-yellow-600 text-white text-center py-2 rounded text-sm hover:bg-yellow-700 transition duration-200">
                                        Редактировать
                                    </a>
                                </div>

                                <!-- Быстрые действия -->
                                <div class="flex gap-2 mt-2">
                                    <form method="POST" action="{{ route('admin.artworks.toggle-featured', $artwork) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full {{ $artwork->is_featured ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-gray-500 hover:bg-gray-600' }} text-white py-1 rounded text-xs transition duration-200">
                                            {{ $artwork->is_featured ? 'Убрать из избранных' : 'В избранное' }}
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('admin.artworks.toggle-availability', $artwork) }}" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full {{ $artwork->is_available ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white py-1 rounded text-xs transition duration-200">
                                            {{ $artwork->is_available ? 'Скрыть' : 'Показать' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $artworks->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-lg mb-4">Произведения не найдены</div>
                    <a href="{{ route('admin.artworks.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition duration-200">
                        Создать первое произведение
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>