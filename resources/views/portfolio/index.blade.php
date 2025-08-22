<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Портфолио - Delightful Life</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-3xl font-bold text-gray-900">Delightful Life</h1>
                <nav class="space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Главная</a>
                    <a href="{{ route('portfolio.index') }}" class="text-indigo-600 font-semibold">Портфолио</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-indigo-600">Услуги</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center mb-12">Портфолио</h1>
            
            <!-- Фильтры -->
            @if($categories->count() > 0)
            <div class="flex justify-center mb-12">
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('portfolio.index') }}" 
                       class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        Все
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('portfolio.index', ['category' => $category->slug]) }}" 
                       class="px-4 py-2 rounded-full {{ request('category') === $category->slug ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Галерея -->
            @if($artworks->count() > 0)
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach($artworks as $artwork)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <div class="h-48 bg-gray-300"></div>
                    <div class="p-4">
                        <h3 class="font-semibold mb-2">{{ $artwork->title }}</h3>
                        @if($artwork->year_created)
                        <p class="text-sm text-gray-600">{{ $artwork->year_created }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Пагинация -->
            {{ $artworks->links() }}
            @else
            <div class="text-center py-12">
                <p class="text-gray-600">Пока нет работ для отображения.</p>
            </div>
            @endif
        </div>
    </main>
</body>
</html>