<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->site_name ?? 'Художественная студия' }} - {{ $settings->site_tagline ?? 'Искусство' }}</title>
    
    <!-- Font preloading for performance -->
    <link rel="preload" href="/fonts/instrument-sans-latin-400.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/instrument-sans-latin-500.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/instrument-sans-latin-600.woff2" as="font" type="font/woff2" crossorigin>
    <link href="/fonts/instrument-sans.css" rel="stylesheet">
    <meta name="description" content="{{ $settings->site_description ?? 'Персональный сайт художника. Портфолио, услуги, заказы.' }}">
    <meta name="keywords" content="{{ setting('meta_keywords', 'художник, искусство, портрет, живопись, заказ') }}">
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
    <x-site-header current-route="home" />

    <main class="flex-grow">
        <!-- Hero секция -->
        <section class="bg-indigo-700 text-white py-12 sm:py-16 lg:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 sm:mb-6 leading-tight">
                    @if($settings->site_tagline)
                        {{ $settings->site_tagline }}
                    @else
                        Добро пожаловать в мир искусства
                    @endif
                </h2>
                <p class="text-lg sm:text-xl mb-6 sm:mb-8 max-w-2xl mx-auto leading-relaxed">
                    {{ $settings->site_description ?? 'Создаю уникальные произведения искусства, воплощая ваши мечты в красках и формах' }}
                </p>
                <a href="{{ route('portfolio.index') }}" class="inline-block bg-white text-indigo-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 text-base sm:text-lg">
                    Посмотреть работы
                </a>
            </div>
        </section>

        <!-- Услуги -->
        @if($services->count() > 0)
        <section class="py-12 sm:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12">Мои услуги</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($services as $service)
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-300">
                        <h3 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4 text-sm sm:text-base leading-relaxed">{{ $service->description }}</p>
                        @if($service->price_from)
                        <p class="text-lg font-bold text-indigo-600 mb-4">
                            от {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                        </p>
                        @endif
                        <a href="{{ route('services.show', $service) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition duration-150">
                            Подробнее
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Рекомендуемые работы -->
        @if($featuredArtworks->count() > 0)
        <section class="py-12 sm:py-16 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-12">Избранные работы</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($featuredArtworks as $artwork)
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                        <a href="{{ route('portfolio.show', $artwork) }}" class="block">
                            @if($artwork->image_path)
                            <div class="h-64 bg-gray-200 overflow-hidden">
                                <img src="{{ asset('storage/' . $artwork->image_path) }}" 
                                     alt="{{ $artwork->title }}" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                     loading="lazy">
                            </div>
                            @else
                            <div class="h-64 bg-gray-300 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </a>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $artwork->title }}</h3>
                            @if($artwork->description)
                            <p class="text-gray-600 mb-3">{{ Str::limit($artwork->description, 100) }}</p>
                            @endif
                            <div class="flex justify-between items-center">
                                @if($artwork->technique)
                                <span class="text-sm text-gray-500">{{ $artwork->technique }}</span>
                                @endif
                                @if($artwork->year)
                                <span class="text-sm text-gray-500">{{ $artwork->year }} г.</span>
                                @endif
                            </div>
                            <a href="{{ route('portfolio.show', $artwork) }}" class="inline-block mt-4 text-indigo-600 hover:text-indigo-800 font-medium">
                                Посмотреть →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>

    <x-site-footer />

</body>
</html>