<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статус заказа - Delightful Life</title>
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
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Статус заказа</h1>
        <p class="text-xl text-gray-600">
            Введите номер заказа, чтобы узнать текущий статус
        </p>
    </div>

    <!-- Форма поиска заказа -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
        <form method="GET" action="{{ route('orders.status') }}" class="max-w-md mx-auto">
            <div class="space-y-4">
                <div>
                    <label for="order_number" class="block text-sm font-semibold text-gray-900 mb-2">
                        Номер заказа
                    </label>
                    <input type="text" 
                           name="order_number" 
                           id="order_number"
                           value="{{ request('order_number') }}"
                           placeholder="ORD-2025-0001"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-center text-lg font-mono">
                </div>
                
                <button type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition-colors">
                    Проверить статус
                </button>
            </div>
        </form>
    </div>

    @if($errorMessage)
        <!-- Сообщение об ошибке -->
        <div class="bg-red-50 border border-red-200 rounded-2xl p-8 text-center">
            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.232 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-red-900 mb-2">Заказ не найден</h2>
            <p class="text-red-700 mb-6">{{ $errorMessage }}</p>
            <div class="text-sm text-red-600">
                <p>Убедитесь, что номер заказа введен правильно</p>
                <p class="mt-1">Номер заказа имеет формат: ORD-YYYY-NNNN</p>
            </div>
        </div>
    @endif

    @if($order)
        <!-- Информация о заказе -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Основная информация -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Заказ {{ $order->order_number }}</h2>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'in_progress' => 'bg-purple-100 text-purple-800',
                            'review' => 'bg-orange-100 text-orange-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="px-4 py-2 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ App\Models\Order::getStatuses()[$order->status] }}
                    </span>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Услуга:</span>
                        <span class="text-gray-900 font-medium">{{ $order->service->name }}</span>
                    </div>

                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Клиент:</span>
                        <span class="text-gray-900 font-medium">{{ $order->client_name }}</span>
                    </div>

                    @if($order->price > 0)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Стоимость:</span>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($order->price, 0, ',', ' ') }} ₽</span>
                        </div>
                    @endif

                    @if($order->deposit)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Депозит:</span>
                            <div class="text-right">
                                <div class="text-lg font-medium text-gray-900">{{ number_format($order->deposit, 0, ',', ' ') }} ₽</div>
                                @if($order->deposit_paid)
                                    <span class="text-green-600 text-sm">✓ Оплачен</span>
                                @else
                                    <span class="text-red-600 text-sm">⚠ Не оплачен</span>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($order->deadline)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600 font-medium">Срок выполнения:</span>
                            <span class="text-gray-900 font-medium">{{ $order->deadline->format('d.m.Y') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600 font-medium">Дата создания:</span>
                        <span class="text-gray-900 font-medium">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between items-center py-3">
                        <span class="text-gray-600 font-medium">Последнее обновление:</span>
                        <span class="text-gray-900 font-medium">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Описание и детали -->
            <div class="space-y-6">
                @if($order->description)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Описание заказа</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $order->description }}</p>
                    </div>
                @endif

                @if($order->requirements && count($order->requirements) > 0)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Дополнительные требования</h3>
                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                            @foreach($order->requirements as $requirement)
                                <li>{{ $requirement }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($order->dimensions)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Размеры</h3>
                        <p class="text-gray-700">{{ $order->dimensions }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Прогресс выполнения -->
        <div class="mt-8 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Прогресс выполнения</h3>
            
            @php
                $statuses = [
                    'pending' => ['title' => 'Заказ получен', 'description' => 'Ваш заказ принят и ожидает обработки'],
                    'confirmed' => ['title' => 'Заказ подтвержден', 'description' => 'Детали согласованы, заказ подтвержден'],
                    'in_progress' => ['title' => 'В работе', 'description' => 'Мы работаем над вашим заказом'],
                    'review' => ['title' => 'На согласовании', 'description' => 'Результат готов к вашему просмотру'],
                    'completed' => ['title' => 'Завершен', 'description' => 'Заказ выполнен и передан клиенту'],
                    'cancelled' => ['title' => 'Отменен', 'description' => 'Заказ был отменен'],
                ];

                $currentStatusIndex = array_search($order->status, array_keys($statuses));
                $statusKeys = array_keys($statuses);
            @endphp

            <div class="space-y-4">
                @foreach($statuses as $key => $statusInfo)
                    @php
                        $statusIndex = array_search($key, $statusKeys);
                        $isCompleted = $statusIndex <= $currentStatusIndex;
                        $isCurrent = $key === $order->status;
                    @endphp
                    
                    <div class="flex items-center {{ $order->status === 'cancelled' && $key !== 'cancelled' ? 'opacity-50' : '' }}">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center mr-4
                                    {{ $isCompleted ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-400' }}
                                    {{ $isCurrent ? 'ring-4 ring-indigo-200' : '' }}">
                            @if($isCompleted && !$isCurrent)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                <span class="text-sm font-bold">{{ $statusIndex + 1 }}</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 {{ $isCurrent ? 'text-indigo-600' : '' }}">
                                {{ $statusInfo['title'] }}
                                @if($isCurrent)
                                    <span class="text-sm font-normal text-indigo-600">(текущий этап)</span>
                                @endif
                            </h4>
                            <p class="text-gray-600 text-sm">{{ $statusInfo['description'] }}</p>
                        </div>
                    </div>

                    @if(!$loop->last && $order->status !== 'cancelled')
                        <div class="flex">
                            <div class="w-10 flex justify-center">
                                <div class="w-0.5 h-4 {{ $isCompleted ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Контактная информация -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 p-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Вопросы по заказу?</h3>
            <p class="text-gray-600 mb-6">
                Если у вас есть вопросы по заказу, свяжитесь с нами
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="mailto:info@example.com?subject=Вопрос по заказу {{ $order->order_number }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Написать email
                </a>
                <a href="{{ route('contact.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.471L3 21l1.529-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                    </svg>
                    Связаться с нами
                </a>
            </div>
        </div>
    @endif

    <!-- Дополнительные ссылки -->
    <div class="mt-8 text-center space-y-4">
        <a href="{{ route('orders.create') }}" 
           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg transition-colors">
            Оформить новый заказ
        </a>
        
        <div>
            <a href="{{ route('home') }}" 
               class="text-indigo-600 hover:text-indigo-800 font-medium">
                Вернуться на главную
            </a>
            <span class="mx-2 text-gray-400">•</span>
            <a href="{{ route('portfolio.index') }}" 
               class="text-indigo-600 hover:text-indigo-800 font-medium">
                Посмотреть работы
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Автоматически подставляем номер заказа из localStorage, если он есть
    const lastOrderNumber = localStorage.getItem('lastOrderNumber');
    const orderInput = document.getElementById('order_number');
    
    if (lastOrderNumber && !orderInput.value) {
        orderInput.value = lastOrderNumber;
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