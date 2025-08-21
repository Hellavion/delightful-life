<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->name }} - Delightful Life</title>
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
                    <a href="{{ route('services.index') }}" class="text-indigo-600 font-semibold">Услуги</a>
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Хлебные крошки -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Главная</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-indigo-600">Услуги</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900">{{ $service->name }}</li>
                </ol>
            </nav>

            <div class="grid lg:grid-cols-3 gap-12">
                <!-- Основная информация об услуге -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <!-- Заголовок -->
                        <div class="p-8">
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $service->name }}</h1>
                            <p class="text-xl text-gray-600 leading-relaxed">{{ $service->description }}</p>
                        </div>

                        @if($service->process_description)
                        <!-- Процесс работы -->
                        <div class="px-8 py-6 bg-gray-50">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Процесс работы</h2>
                            <div class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($service->process_description)) !!}
                            </div>
                        </div>
                        @endif

                        @if($service->features && count($service->features) > 0)
                        <!-- Что включено -->
                        <div class="p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Что включено в услугу</h2>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($service->features as $feature)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Боковая панель -->
                <div class="space-y-8">
                    <!-- Цена и заказ -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Стоимость и заказ</h3>
                        
                        @if($service->price_from)
                        <div class="mb-6">
                            <div class="text-3xl font-bold text-indigo-600 mb-2">
                                @if($service->pricing_type === 'range' && $service->price_to)
                                    {{ number_format($service->price_from, 0, ',', ' ') }} - {{ number_format($service->price_to, 0, ',', ' ') }} ₽
                                @else
                                    от {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">
                                @if($service->pricing_type === 'range')
                                    Стоимость зависит от сложности и объема работы
                                @elseif($service->pricing_type === 'custom')
                                    Стоимость рассчитывается индивидуально
                                @else
                                    Фиксированная стоимость
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($service->duration)
                        <div class="mb-6">
                            <div class="flex items-center text-gray-700 mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Сроки выполнения:</span>
                            </div>
                            <p class="text-gray-600 ml-7">{{ $service->duration }}</p>
                        </div>
                        @endif

                        <a href="{{ route('contact.index') }}?service={{ $service->slug }}" 
                           class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 transition font-medium text-center block">
                            Заказать услугу
                        </a>
                    </div>

                    <!-- Дополнительная информация -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Полезная информация</h3>
                        
                        <div class="space-y-4 text-sm text-gray-600">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <p>Консультация по проекту проводится бесплатно</p>
                            </div>
                            
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <p>Возможна частичная предоплата (30-50%)</p>
                            </div>
                            
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <p>Поэтапное согласование работы с клиентом</p>
                            </div>
                            
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <p>Гарантия качества и соблюдения сроков</p>
                            </div>
                        </div>
                    </div>

                    <!-- Связаться -->
                    <div class="bg-indigo-50 p-6 rounded-lg">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">Есть вопросы?</h3>
                        <p class="text-gray-600 mb-4 text-sm">Свяжитесь со мной для получения подробной консультации по вашему проекту.</p>
                        
                        <div class="space-y-2 text-sm">
                            <a href="mailto:hello@delightful-life.com" class="flex items-center text-indigo-600 hover:text-indigo-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                hello@delightful-life.com
                            </a>
                            
                            <a href="tel:+79991234567" class="flex items-center text-indigo-600 hover:text-indigo-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                +7 (999) 123-45-67
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Другие услуги -->
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Другие услуги</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @php
                        $otherServices = \App\Models\Service::where('is_active', true)
                            ->where('id', '!=', $service->id)
                            ->orderBy('sort_order')
                            ->limit(3)
                            ->get();
                    @endphp
                    
                    @foreach($otherServices as $otherService)
                    <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-3">{{ $otherService->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($otherService->description, 100) }}</p>
                        
                        @if($otherService->price_from)
                        <div class="text-lg font-bold text-indigo-600 mb-4">
                            @if($otherService->pricing_type === 'range' && $otherService->price_to)
                                {{ number_format($otherService->price_from, 0, ',', ' ') }} - {{ number_format($otherService->price_to, 0, ',', ' ') }} ₽
                            @else
                                от {{ number_format($otherService->price_from, 0, ',', ' ') }} ₽
                            @endif
                        </div>
                        @endif
                        
                        <a href="{{ route('services.show', $otherService) }}" 
                           class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Подробнее →
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Delightful Life. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>