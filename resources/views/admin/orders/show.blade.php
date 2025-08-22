<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ {{ $order->order_number }} - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.orders.index') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к списку заказов
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Просмотр заказа</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">
                        Добро пожаловать, {{ Auth::guard('admin')->user()->name }}!
                    </span>
                    
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-200"
                        >
                            Выйти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Заказ {{ $order->order_number }}</h1>
                <p class="mt-2 text-gray-600">Детальная информация о заказе</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.orders.edit', $order) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Редактировать
                </a>
                <a href="{{ route('admin.orders.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Назад к списку
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Основная информация -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Детали заказа -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Детали заказа</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Услуга</label>
                        <p class="text-gray-900">{{ $order->service->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Описание заказа</label>
                        <p class="text-gray-900 whitespace-pre-line">{{ $order->description }}</p>
                    </div>

                    @if($order->requirements)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Дополнительные требования</label>
                            <ul class="list-disc list-inside text-gray-900 space-y-1">
                                @foreach($order->requirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($order->dimensions)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Размеры</label>
                            <p class="text-gray-900">{{ $order->dimensions }}</p>
                        </div>
                    @endif

                    @if($order->deadline)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Желаемые сроки</label>
                            <p class="text-gray-900">{{ $order->deadline->format('d.m.Y') }}</p>
                        </div>
                    @endif

                    @if($order->notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Заметки администратора</label>
                            <p class="text-gray-900 whitespace-pre-line">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Быстрые действия -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Быстрые действия</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if(!$order->deposit_paid && $order->deposit)
                        <form method="POST" action="{{ route('admin.orders.mark-deposit-paid', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Отметить депозит оплаченным
                            </button>
                        </form>
                    @endif

                    @if(!$order->full_payment_received)
                        <form method="POST" action="{{ route('admin.orders.mark-fully-paid', $order) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Отметить полностью оплаченным
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Изменение статуса -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Изменить статус</h2>
                
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Статус</label>
                            <select name="status" 
                                    id="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach(App\Models\Order::getStatuses() as $key => $label)
                                    <option value="{{ $key }}" @selected($order->status === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Заметки (необязательно)</label>
                            <textarea name="notes" 
                                      id="notes"
                                      rows="3"
                                      placeholder="Добавить заметку о изменении статуса..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes') }}</textarea>
                        </div>

                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Обновить статус
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Боковая панель -->
        <div class="space-y-6">
            <!-- Информация о клиенте -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Клиент</h2>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Имя</label>
                        <p class="text-gray-900">{{ $order->client_name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-gray-900">
                            <a href="mailto:{{ $order->client_email }}" 
                               class="text-indigo-600 hover:text-indigo-800">
                                {{ $order->client_email }}
                            </a>
                        </p>
                    </div>

                    @if($order->client_phone)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Телефон</label>
                            <p class="text-gray-900">
                                <a href="tel:{{ $order->client_phone }}" 
                                   class="text-indigo-600 hover:text-indigo-800">
                                    {{ $order->client_phone }}
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Финансовая информация -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Финансы</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-700">Общая сумма:</span>
                        <span class="font-medium text-gray-900">{{ number_format($order->price, 0, ',', ' ') }} ₽</span>
                    </div>

                    @if($order->deposit)
                        <div class="flex justify-between">
                            <span class="text-gray-700">Депозит:</span>
                            <span class="font-medium text-gray-900">
                                {{ number_format($order->deposit, 0, ',', ' ') }} ₽
                                @if($order->deposit_paid)
                                    <span class="text-green-600 ml-1">✓ Оплачен</span>
                                @else
                                    <span class="text-red-600 ml-1">⚠ Не оплачен</span>
                                @endif
                            </span>
                        </div>
                    @endif

                    <div class="flex justify-between border-t pt-3">
                        <span class="text-gray-700">Статус оплаты:</span>
                        <span class="font-medium {{ $order->full_payment_received ? 'text-green-600' : 'text-red-600' }}">
                            {{ $order->full_payment_received ? 'Полностью оплачен' : 'Не оплачен' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Информация о заказе -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Информация</h2>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-700">Создан:</span>
                        <span class="text-gray-900">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-700">Обновлен:</span>
                        <span class="text-gray-900">{{ $order->updated_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-700">Текущий статус:</span>
                        @php
                            $statusColors = [
                                'pending' => 'text-yellow-600',
                                'confirmed' => 'text-blue-600',
                                'in_progress' => 'text-purple-600',
                                'review' => 'text-orange-600',
                                'completed' => 'text-green-600',
                                'cancelled' => 'text-red-600',
                            ];
                        @endphp
                        <span class="font-medium {{ $statusColors[$order->status] ?? 'text-gray-600' }}">
                            {{ App\Models\Order::getStatuses()[$order->status] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</body>
</html>