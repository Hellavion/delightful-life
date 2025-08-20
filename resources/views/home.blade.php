<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delightful Life - Художественная студия</title>
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
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-indigo-600">Блог</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero секция -->
        <section class="bg-indigo-700 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-5xl font-bold mb-6">Добро пожаловать в мир искусства</h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    Создаю уникальные произведения искусства, воплощая ваши мечты в красках и формах
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Delightful Life. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>