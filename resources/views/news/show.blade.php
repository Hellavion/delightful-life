<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Delightful Life</title>
    
    <!-- Font preloading -->
    <link rel="preload" href="/fonts/instrument-sans-latin-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/instrument-sans-latin-500.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/instrument-sans-latin-600.woff2" as="font" type="font/woff2" crossorigin>
    <link href="/fonts/instrument-sans.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-site-header current-route="news.show" />

    <main class="flex-grow">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Хлебные крошки -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Главная</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('news.index') }}" class="hover:text-indigo-600">Новости</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">{{ $post->title }}</li>
                </ol>
            </nav>

            <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($post->featured_image)
                <div class="h-96 bg-gray-300 flex items-center justify-center">
                    <span class="text-gray-500">Изображение статьи</span>
                </div>
                @endif

                <div class="p-8">
                    <!-- Заголовок и мета-информация -->
                    <header class="mb-8">
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                                {{ $post->published_at->format('d F Y') }}
                            </time>
                            @if($post->is_featured)
                            <span class="mx-2">•</span>
                            <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">Рекомендуемое</span>
                            @endif
                        </div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                        
                        @if($post->excerpt)
                        <p class="text-xl text-gray-600 leading-relaxed">{{ $post->excerpt }}</p>
                        @endif
                    </header>

                    <!-- Содержание -->
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Теги -->
                    @if($post->tags && count($post->tags) > 0)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Теги:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                {{ $tag }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </article>

            <!-- Связанные новости -->
            @if($relatedPosts->count() > 0)
            <section class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Похожие новости</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $relatedPost)
                    <article class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                        @if($relatedPost->featured_image)
                        <div class="h-48 bg-gray-300"></div>
                        @endif
                        <div class="p-6">
                            <div class="text-sm text-gray-600 mb-2">
                                <time datetime="{{ $relatedPost->published_at->format('Y-m-d') }}">
                                    {{ $relatedPost->published_at->format('d.m.Y') }}
                                </time>
                            </div>
                            <h3 class="text-lg font-semibold mb-3">{{ $relatedPost->title }}</h3>
                            @if($relatedPost->excerpt)
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                            @else
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit(strip_tags($relatedPost->content), 100) }}</p>
                            @endif
                            <a href="{{ route('news.show', $relatedPost) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Читать далее →
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Навигация -->
            <div class="mt-12">
                <a href="{{ route('news.index') }}" 
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                    ← Вернуться к новостям
                </a>
            </div>
        </div>
    </main>

    <x-site-footer />
</body>
</html>