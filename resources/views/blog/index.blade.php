<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новости - Delightful Life</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-3xl font-bold text-gray-900">Delightful Life</h1>
                <nav class="space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Главная</a>
                    <a href="{{ route('portfolio.index') }}" class="text-gray-700 hover:text-indigo-600">Портфолио</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-indigo-600">Услуги</a>
                    <a href="{{ route('blog.index') }}" class="text-indigo-600 font-semibold">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center mb-12">Новости и события</h1>
            
            <!-- Поиск -->
            <div class="max-w-md mx-auto mb-12">
                <form method="GET" action="{{ route('blog.index') }}" class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Поиск новостей..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <button type="submit" class="absolute right-2 top-2 text-gray-500 hover:text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            @if($featuredPosts->count() > 0)
            <!-- Рекомендуемые новости -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold mb-8">Рекомендуемые новости</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($featuredPosts as $post)
                    <article class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                        @if($post->featured_image)
                        <div class="h-48 bg-gray-300"></div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                    {{ $post->published_at->format('d.m.Y') }}
                                </time>
                                <span class="mx-2">•</span>
                                <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">Рекомендуемое</span>
                            </div>
                            <h3 class="text-xl font-semibold mb-3">{{ $post->title }}</h3>
                            @if($post->excerpt)
                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                            @endif
                            <a href="{{ route('blog.show', $post) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Читать далее →
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Все новости -->
            @if($posts->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($posts as $post)
                <article class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    @if($post->featured_image)
                    <div class="h-48 bg-gray-300"></div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                {{ $post->published_at->format('d.m.Y') }}
                            </time>
                            @if($post->is_featured)
                            <span class="mx-2">•</span>
                            <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">Рекомендуемое</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold mb-3">{{ $post->title }}</h3>
                        @if($post->excerpt)
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($post->excerpt, 120) }}</p>
                        @else
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                        @endif
                        <a href="{{ route('blog.show', $post) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Читать далее →
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Пагинация -->
            {{ $posts->links() }}
            @else
            <div class="text-center py-12">
                <div class="text-gray-500 text-6xl mb-4">📰</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Пока нет новостей</h3>
                <p class="text-gray-600">Следите за обновлениями - здесь будут появляться интересные статьи о творчестве, выставках и событиях.</p>
            </div>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Delightful Life. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>