<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->site_name ?? 'Художественная студия' }} - {{ $settings->site_tagline ?? 'Искусство' }}</title>
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
<body class="bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $settings->site_name ?? 'Художественная студия' }}</h1>
                <nav class="space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Главная</a>
                    <a href="{{ route('portfolio.index') }}" class="text-gray-700 hover:text-indigo-600">Портфолио</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-indigo-600">Услуги</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero секция -->
        <section class="bg-indigo-700 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-5xl font-bold mb-6">
                    @if($settings->site_tagline)
                        {{ $settings->site_tagline }}
                    @else
                        Добро пожаловать в мир искусства
                    @endif
                </h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    {{ $settings->site_description ?? 'Создаю уникальные произведения искусства, воплощая ваши мечты в красках и формах' }}
                </p>
                <a href="{{ route('portfolio.index') }}" class="bg-white text-indigo-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Посмотреть работы
                </a>
            </div>
        </section>

        <!-- Услуги -->
        @if($services->count() > 0)
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Мои услуги</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($services as $service)
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-4">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                        @if($service->price_from)
                        <p class="text-lg font-bold text-indigo-600 mb-4">
                            от {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                        </p>
                        @endif
                        <a href="{{ route('services.show', $service) }}" class="text-indigo-600 hover:text-indigo-800">
                            Подробнее →
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Рекомендуемые работы -->
        @if($featuredArtworks->count() > 0)
        <section class="py-16 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center mb-12">Избранные работы</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($featuredArtworks as $artwork)
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                        <div class="h-64 bg-gray-300"></div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $artwork->title }}</h3>
                            @if($artwork->description)
                            <p class="text-gray-600 mb-4">{{ Str::limit($artwork->description, 100) }}</p>
                            @endif
                            <a href="{{ route('portfolio.show', $artwork) }}" class="text-indigo-600 hover:text-indigo-800">
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

    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <!-- Контактная информация -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Контакты</h3>
                    @if($settings->contact_email)
                    <p class="mb-2">
                        <span class="text-gray-400">Email:</span>
                        <a href="mailto:{{ $settings->contact_email }}" class="hover:text-indigo-400 transition">
                            {{ $settings->contact_email }}
                        </a>
                    </p>
                    @endif
                    @if($settings->contact_phone)
                    <p class="mb-2">
                        <span class="text-gray-400">Телефон:</span>
                        <a href="tel:{{ $settings->contact_phone }}" class="hover:text-indigo-400 transition">
                            {{ $settings->contact_phone }}
                        </a>
                    </p>
                    @endif
                    @if(setting('contact_address'))
                    <p class="mb-2">
                        <span class="text-gray-400">Адрес:</span>
                        {{ setting('contact_address') }}
                    </p>
                    @endif
                    @if(setting('working_hours'))
                    <p class="text-gray-400">{{ setting('working_hours') }}</p>
                    @endif
                </div>

                <!-- Социальные сети -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Социальные сети</h3>
                    <div class="flex space-x-4">
                        @if($settings->social_instagram)
                        <a href="{{ $settings->social_instagram }}" target="_blank" class="hover:text-indigo-400 transition">
                            Instagram
                        </a>
                        @endif
                        @if($settings->social_telegram)
                        <a href="{{ $settings->social_telegram }}" target="_blank" class="hover:text-indigo-400 transition">
                            Telegram
                        </a>
                        @endif
                        @if($settings->social_vk)
                        <a href="{{ $settings->social_vk }}" target="_blank" class="hover:text-indigo-400 transition">
                            ВКонтакте
                        </a>
                        @endif
                        @if($settings->social_behance)
                        <a href="{{ $settings->social_behance }}" target="_blank" class="hover:text-indigo-400 transition">
                            Behance
                        </a>
                        @endif
                    </div>
                </div>

                <!-- О художнике -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ $settings->artist_name ?? 'Художник' }}</h3>
                    <p class="text-gray-400">{{ $settings->site_name ?? 'Художественная студия' }}</p>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 text-center">
                <p>&copy; {{ date('Y') }} {{ $settings->site_name ?? 'Художественная студия' }}. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>