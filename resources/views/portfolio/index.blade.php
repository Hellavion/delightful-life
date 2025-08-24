<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Портфолио - {{ $settings->site_name ?? 'Художественная студия' }}</title>
    
    <!-- Font preloading -->
    <link rel="preload" href="/fonts/instrument-sans-latin-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/instrument-sans-latin-500.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/instrument-sans-latin-600.woff2" as="font" type="font/woff2" crossorigin>
    <link href="/fonts/instrument-sans.css" rel="stylesheet">
    <meta name="description" content="Портфолио {{ $settings->artist_name ?? 'художника' }}. {{ $settings->site_description ?? 'Галерея работ, живопись, искусство.' }}">
    <meta name="keywords" content="{{ setting('meta_keywords', 'портфолио, художник, искусство, живопись, заказ') }}">
    <meta name="author" content="{{ $settings->artist_name ?? setting('meta_author', 'Художник') }}">
    
    @if(setting('google_analytics'))
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ setting('google_analytics') }}');
    </script>
    @endif
    
    @if(setting('yandex_metrica'))
    <!-- Яндекс.Метрика -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym({{ setting('yandex_metrica') }}, "init", {clickmap:true,trackLinks:true,accurateTrackBounce:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/{{ setting('yandex_metrica') }}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <x-site-header current-route="portfolio.index" />

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-center mb-8 sm:mb-12">Портфолио</h1>
            
            <!-- Фильтры -->
            @if($categories->count() > 0)
            <div class="flex justify-center mb-8 sm:mb-12">
                <div class="flex flex-wrap justify-center gap-2 sm:gap-4 px-2">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 mb-8 sm:mb-12">
                @foreach($artworks as $artwork)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <a href="{{ route('portfolio.show', $artwork) }}" class="block">
                        @if($artwork->image_path)
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="{{ asset('storage/' . $artwork->image_path) }}" 
                                 alt="{{ $artwork->title }}" 
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                        @else
                        <div class="h-48 bg-gray-300 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold mb-2 text-gray-900">{{ $artwork->title }}</h3>
                            @if($artwork->technique)
                            <p class="text-sm text-gray-600 mb-1">{{ $artwork->technique }}</p>
                            @endif
                            @if($artwork->year)
                            <p class="text-sm text-gray-500">{{ $artwork->year }} г.</p>
                            @endif
                            @if($artwork->price && $artwork->is_available)
                            <p class="text-sm font-medium text-indigo-600 mt-2">{{ number_format($artwork->price, 0, ',', ' ') }} ₽</p>
                            @endif
                        </div>
                    </a>
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

    <x-site-footer />
</body>
</html>