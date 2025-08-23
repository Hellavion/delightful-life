<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Услуги - {{ $settings->site_name ?? 'Художественная студия' }}</title>
    <meta name="description" content="Услуги {{ $settings->artist_name ?? 'художника' }}. {{ $settings->site_description ?? 'Портреты, живопись, индивидуальные заказы.' }}">
    <meta name="keywords" content="{{ setting('meta_keywords', 'услуги, художник, портрет, живопись, заказ') }}">
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
<body class="bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $settings->site_name ?? 'Художественная студия' }}</h1>
                <nav class="space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Главная</a>
                    <a href="{{ route('portfolio.index') }}" class="text-gray-700 hover:text-indigo-600">Портфолио</a>
                    <a href="{{ route('services.index') }}" class="text-indigo-600 font-semibold">Услуги</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center mb-12">Мои услуги</h1>
            
            @if($services->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="bg-white p-8 rounded-lg shadow hover:shadow-lg transition">
                    <h2 class="text-2xl font-bold mb-4">{{ $service->name }}</h2>
                    <p class="text-gray-600 mb-6">{{ $service->description }}</p>
                    
                    @if($service->features)
                    <ul class="text-sm text-gray-600 mb-6 space-y-2">
                        @foreach($service->features as $feature)
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-indigo-600 rounded-full mr-3"></span>
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    <div class="flex justify-between items-center">
                        @if($service->price_from)
                        <div class="text-lg font-bold text-indigo-600">
                            @if($service->pricing_type === 'range' && $service->price_to)
                                {{ number_format($service->price_from, 0, ',', ' ') }} - {{ number_format($service->price_to, 0, ',', ' ') }} ₽
                            @else
                                от {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                            @endif
                        </div>
                        @endif
                        
                        <a href="{{ route('services.show', $service) }}" 
                           class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                            Подробнее
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <p class="text-gray-600">Пока нет услуг для отображения.</p>
            </div>
            @endif
        </div>
    </main>
</body>
</html>