<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформить заказ - Delightful Life</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    <a href="{{ route('home') }}">Delightful Life</a>
                </h1>
                <nav class="space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Главная</a>
                    <a href="{{ route('portfolio.index') }}" class="text-gray-700 hover:text-indigo-600">Портфолио</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-indigo-600">Услуги</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-gray-700 hover:text-indigo-600">Контакты</a>
                    <a href="{{ route('orders.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Заказать</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Оформить заказ</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            Расскажите о своих идеях, и мы создадим для вас уникальное произведение
        </p>
    </div>

    <form method="POST" action="{{ route('orders.store') }}" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Левая колонка -->
            <div class="space-y-8">
                <!-- Выбор услуги -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Выберите услугу</h2>
                    
                    <div class="space-y-4">
                        @foreach($services as $service)
                            <label class="block">
                                <input type="radio" 
                                       name="service_id" 
                                       value="{{ $service->id }}"
                                       @checked(old('service_id', $selectedService?->id) == $service->id)
                                       class="sr-only peer"
                                       data-price-from="{{ $service->price_from }}"
                                       data-price-to="{{ $service->price_to }}">
                                
                                <div class="border-2 border-gray-200 rounded-xl p-6 cursor-pointer transition-all
                                           peer-checked:border-indigo-500 peer-checked:bg-indigo-50 
                                           hover:border-gray-300 hover:shadow-md">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                {{ $service->name }}
                                            </h3>
                                            <p class="text-gray-600 text-sm mb-3">
                                                {{ Str::limit($service->description, 120) }}
                                            </p>
                                            @if($service->price_from || $service->price_to)
                                                <div class="text-indigo-600 font-medium">
                                                    @if($service->price_from && $service->price_to)
                                                        от {{ number_format($service->price_from, 0, ',', ' ') }} до {{ number_format($service->price_to, 0, ',', ' ') }} ₽
                                                    @elseif($service->price_from)
                                                        от {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 
                                                        peer-checked:border-indigo-500 peer-checked:bg-indigo-500
                                                        flex items-center justify-center">
                                                <div class="w-3 h-3 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                        
                        @error('service_id')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Детали заказа -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Детали заказа</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">
                                Опишите ваши идеи <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      rows="5"
                                      required
                                      placeholder="Расскажите подробно о том, что вы хотите получить. Укажите стиль, настроение, цветовые предпочтения, любые важные детали..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="dimensions" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Размеры
                                </label>
                                <input type="text" 
                                       name="dimensions" 
                                       id="dimensions"
                                       value="{{ old('dimensions') }}"
                                       placeholder="30x40 см, A4, 1920x1080 px"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('dimensions') border-red-500 @enderror">
                                @error('dimensions')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="deadline" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Желаемые сроки
                                </label>
                                <input type="date" 
                                       name="deadline" 
                                       id="deadline"
                                       value="{{ old('deadline') }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deadline') border-red-500 @enderror">
                                @error('deadline')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Дополнительные требования (опционально) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-3">
                                Дополнительные требования (выберите подходящие)
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @php
                                    $commonRequirements = [
                                        'Высокое разрешение',
                                        'Исходные файлы',
                                        'Несколько вариантов',
                                        'Возможность правок',
                                        'Коммерческое использование',
                                        'Упаковка/оформление'
                                    ];
                                @endphp
                                
                                @foreach($commonRequirements as $requirement)
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="requirements[]" 
                                               value="{{ $requirement }}"
                                               @checked(in_array($requirement, old('requirements', [])))
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-3 text-sm text-gray-700">{{ $requirement }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая колонка -->
            <div class="space-y-8">
                <!-- Контактная информация -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Контактная информация</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="client_name" class="block text-sm font-semibold text-gray-900 mb-2">
                                Ваше имя <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="client_name" 
                                   id="client_name"
                                   value="{{ old('client_name') }}"
                                   required
                                   placeholder="Как к вам обращаться?"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('client_name') border-red-500 @enderror">
                            @error('client_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="client_email" class="block text-sm font-semibold text-gray-900 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="client_email" 
                                   id="client_email"
                                   value="{{ old('client_email') }}"
                                   required
                                   placeholder="your@email.com"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('client_email') border-red-500 @enderror">
                            @error('client_email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="client_phone" class="block text-sm font-semibold text-gray-900 mb-2">
                                Телефон
                            </label>
                            <input type="tel" 
                                   name="client_phone" 
                                   id="client_phone"
                                   value="{{ old('client_phone') }}"
                                   placeholder="+7 (xxx) xxx-xx-xx"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('client_phone') border-red-500 @enderror">
                            @error('client_phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Информация о заказе -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Что дальше?</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                                1
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Отправка заказа</h3>
                                <p class="text-gray-600 text-sm">После отправки формы вы получите номер заказа</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                                2
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Обсуждение деталей</h3>
                                <p class="text-gray-600 text-sm">Мы свяжемся с вами в течение 24 часов для уточнения деталей</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                                3
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Начало работы</h3>
                                <p class="text-gray-600 text-sm">После согласования всех деталей и внесения депозита</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-white rounded-xl border border-indigo-200">
                        <div class="flex items-center text-indigo-600 mb-2">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-sm">Обычно требуется депозит 30%</span>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Для начала работы над заказом требуется предоплата, которая засчитывается в общую стоимость
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопка отправки -->
        <div class="text-center pt-8">
            <button type="submit" 
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 
                           text-white font-bold py-4 px-12 rounded-2xl text-lg transition-all transform hover:scale-105 
                           shadow-lg hover:shadow-xl">
                Отправить заказ
            </button>
            <p class="text-gray-500 text-sm mt-4">
                Отправляя заказ, вы соглашаетесь с условиями работы
            </p>
        </div>
    </form>
</div>

<script>
// Автоматическое обновление информации при выборе услуги
document.querySelectorAll('input[name="service_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Можно добавить логику для обновления информации о выбранной услуге
        console.log('Selected service:', this.value);
    });
});

// Валидация формы
document.querySelector('form').addEventListener('submit', function(e) {
    const serviceSelected = document.querySelector('input[name="service_id"]:checked');
    if (!serviceSelected) {
        e.preventDefault();
        alert('Пожалуйста, выберите услугу');
        return;
    }

    const description = document.getElementById('description').value.trim();
    if (description.length < 10) {
        e.preventDefault();
        alert('Пожалуйста, опишите ваши идеи более подробно (минимум 10 символов)');
        return;
    }
});
</script>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 Delightful Life. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>