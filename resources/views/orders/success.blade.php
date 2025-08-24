<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ успешно отправлен - Delightful Life</title>
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
        <!-- Иконка успеха -->
        <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-8">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-4xl font-bold text-gray-900 mb-4">Заказ успешно отправлен!</h1>
        <p class="text-xl text-gray-600 mb-8">
            Спасибо за ваш заказ. Мы свяжемся с вами в ближайшее время.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Информация о заказе -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Информация о заказе</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Номер заказа:</span>
                    <span class="text-lg font-bold text-indigo-600">{{ $order->order_number }}</span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Услуга:</span>
                    <span class="text-gray-900 font-medium">{{ $order->service->name }}</span>
                </div>

                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-gray-600 font-medium">Статус:</span>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ App\Models\Order::getStatuses()[$order->status] }}
                    </span>
                </div>

                @if($order->price > 0)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Ориентировочная стоимость:</span>
                        <span class="text-lg font-bold text-gray-900">{{ number_format($order->price, 0, ',', ' ') }} ₽</span>
                    </div>
                @endif

                @if($order->deposit)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Ориентировочный депозит:</span>
                        <span class="text-lg font-medium text-gray-900">{{ number_format($order->deposit, 0, ',', ' ') }} ₽</span>
                    </div>
                @endif

                @if($order->deadline)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Желаемые сроки:</span>
                        <span class="text-gray-900 font-medium">{{ $order->deadline->format('d.m.Y') }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center py-3">
                    <span class="text-gray-600 font-medium">Дата создания:</span>
                    <span class="text-gray-900 font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Что дальше -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Что дальше?</h2>
            
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                        1
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Обработка заказа</h3>
                        <p class="text-gray-600 text-sm">
                            Мы изучим ваш заказ и подготовим предложение с точной стоимостью и сроками
                        </p>
                        <span class="inline-block mt-2 bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">
                            До 24 часов
                        </span>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                        2
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Связь с вами</h3>
                        <p class="text-gray-600 text-sm">
                            Мы свяжемся с вами по указанному email или телефону для обсуждения деталей
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                        3
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Согласование и оплата</h3>
                        <p class="text-gray-600 text-sm">
                            После согласования всех деталей мы попросим внести депозит для начала работы
                        </p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">
                        4
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Создание и доставка</h3>
                        <p class="text-gray-600 text-sm">
                            Мы начнем работу над вашим заказом и будем держать вас в курсе прогресса
                        </p>
                    </div>
                </div>
            </div>

            <!-- Важная информация -->
            <div class="mt-8 p-4 bg-white rounded-xl border border-indigo-200">
                <div class="flex items-center text-indigo-600 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-semibold text-sm">Важно знать</span>
                </div>
                <p class="text-gray-600 text-sm">
                    Указанная стоимость и сроки являются ориентировочными. Точные условия будут согласованы с вами индивидуально.
                </p>
            </div>
        </div>
    </div>

    <!-- Контактная информация -->
    <div class="mt-12 bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Есть вопросы?</h2>
            <p class="text-gray-600 mb-6">
                Если у вас есть срочные вопросы по заказу, вы можете связаться с нами напрямую
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="mailto:info@example.com" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Написать email
                </a>
                
                <a href="{{ route('orders.status') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Проверить статус заказа
                </a>
            </div>
        </div>
    </div>

    <!-- Дополнительные действия -->
    <div class="mt-8 text-center space-y-4">
        <a href="{{ route('home') }}" 
           class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-lg transition-colors">
            Вернуться на главную
        </a>
        
        <div>
            <a href="{{ route('portfolio.index') }}" 
               class="text-indigo-600 hover:text-indigo-800 font-medium">
                Посмотреть другие работы
            </a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('services.index') }}" 
               class="text-indigo-600 hover:text-indigo-800 font-medium">
                Изучить услуги
            </a>
        </div>
    </div>
</div>

<script>
// Копирование номера заказа
document.addEventListener('DOMContentLoaded', function() {
    const orderNumber = '{{ $order->order_number }}';
    
    // Автоматически сохраняем номер заказа в localStorage для удобства
    localStorage.setItem('lastOrderNumber', orderNumber);
});
</script>
    </main>

    <x-site-footer />
</body>
</html>