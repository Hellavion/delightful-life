<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artwork->title }} - Портфолио - Delightful Life</title>
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
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Главная</a></li>
                    <li>/</li>
                    <li><a href="{{ route('portfolio.index') }}" class="hover:text-indigo-600">Портфолио</a></li>
                    <li>/</li>
                    <li class="text-gray-900">{{ $artwork->title }}</li>
                </ol>
            </nav>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Изображение -->
                    <div class="bg-gray-200 aspect-square lg:aspect-auto lg:h-96 xl:h-[600px]">
                        @if($artwork->image_path)
                            <img src="{{ Storage::url($artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <span class="text-lg">Нет изображения</span>
                            </div>
                        @endif
                    </div>

                    <!-- Информация -->
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $artwork->title }}</h1>
                        
                        @if($artwork->description)
                            <p class="text-gray-700 mb-6 leading-relaxed">{{ $artwork->description }}</p>
                        @endif

                        <!-- Детали произведения -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            @if($artwork->technique)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Техника</h3>
                                    <p class="text-gray-900">{{ $artwork->technique }}</p>
                                </div>
                            @endif

                            @if($artwork->year)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Год создания</h3>
                                    <p class="text-gray-900">{{ $artwork->year }}</p>
                                </div>
                            @endif

                            @if($artwork->width && $artwork->height)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Размеры</h3>
                                    <p class="text-gray-900">{{ $artwork->width }} × {{ $artwork->height }} см</p>
                                </div>
                            @endif

                            @if($artwork->price)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Цена</h3>
                                    <p class="text-gray-900 text-xl font-semibold">{{ number_format($artwork->price, 0, ',', ' ') }} ₽</p>
                                </div>
                            @endif
                        </div>

                        <!-- Категории -->
                        @if($artwork->categories->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Категории</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($artwork->categories as $category)
                                        <span class="bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Кнопка связи -->
                        <div class="pt-6 border-t border-gray-200">
                            <a href="{{ route('contact.index') }}" 
                               class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition duration-200">
                                Заказать похожую работу
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Похожие работы -->
            @if($relatedArtworks->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Похожие работы</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($relatedArtworks as $relatedArtwork)
                            <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                                <a href="{{ route('portfolio.show', $relatedArtwork->slug) }}">
                                    <div class="h-48 bg-gray-200">
                                        @if($relatedArtwork->image_path)
                                            <img src="{{ Storage::url($relatedArtwork->image_path) }}" 
                                                 alt="{{ $relatedArtwork->title }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <span class="text-xs">Нет изображения</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-1 hover:text-indigo-600">
                                            {{ $relatedArtwork->title }}
                                        </h3>
                                        @if($relatedArtwork->year)
                                            <p class="text-sm text-gray-600">{{ $relatedArtwork->year }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Delightful Life. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>