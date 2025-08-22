<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр услуги: {{ $service->name }} - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.services.index') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к списку услуг
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">{{ $service->name }}</h1>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $service->is_active ? 'Активна' : 'Неактивна' }}
                    </span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.services.edit', $service) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition duration-200">
                        Редактировать
                    </a>
                    <span class="text-sm text-gray-600">{{ Auth::guard('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200">
                            Выйти
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Уведомления -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Основная информация -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Общая информация -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Общая информация</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Название</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $service->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL-адрес (slug)</label>
                            <p class="mt-1 text-sm text-gray-900 font-mono bg-gray-50 px-2 py-1 rounded">{{ $service->slug }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Описание</label>
                            <div class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none">
                                {!! nl2br(e($service->description)) !!}
                            </div>
                        </div>

                        @if($service->process_description)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Процесс работы</label>
                                <div class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none">
                                    {!! nl2br(e($service->process_description)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Особенности услуги -->
                @if($service->features && count($service->features) > 0)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Что включено в услугу</h2>
                        
                        <ul class="space-y-2">
                            @foreach($service->features as $feature)
                                @if(!empty(trim($feature)))
                                    <li class="flex items-start">
                                        <svg class="flex-shrink-0 h-5 w-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-2 text-sm text-gray-900">{{ $feature }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Связанные заказы -->
                @if($service->orders()->exists())
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Связанные заказы</h2>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Клиент</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата создания</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($service->orders()->latest()->limit(10)->get() as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->client_name ?? 'Не указано' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ ucfirst($order->status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($service->orders()->count() > 10)
                            <div class="mt-4 text-center">
                                <p class="text-sm text-gray-500">Показано 10 из {{ $service->orders()->count() }} заказов</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Боковая панель -->
            <div class="space-y-6">
                <!-- Ценообразование -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ценообразование</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Тип ценообразования</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($service->pricing_type === 'fixed')
                                    Фиксированная цена
                                @elseif($service->pricing_type === 'range')
                                    Диапазон цен
                                @else
                                    Индивидуальная цена
                                @endif
                            </p>
                        </div>

                        @if($service->pricing_type !== 'custom')
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Стоимость</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">
                                    @if($service->pricing_type === 'fixed' && $service->price_from)
                                        {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                                    @elseif($service->pricing_type === 'range' && $service->price_from && $service->price_to)
                                        {{ number_format($service->price_from, 0, ',', ' ') }} - {{ number_format($service->price_to, 0, ',', ' ') }} ₽
                                    @else
                                        <span class="text-gray-500">Не указано</span>
                                    @endif
                                </p>
                            </div>
                        @endif

                        @if($service->duration)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Примерные сроки</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $service->duration }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Настройки публикации -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Настройки публикации</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Статус</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $service->is_active ? 'Активна' : 'Неактивна' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Порядок сортировки</span>
                            <span class="text-sm text-gray-900">{{ $service->sort_order }}</span>
                        </div>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Статистика</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Всего заказов</span>
                            <span class="text-sm text-gray-900 font-semibold">{{ $service->orders()->count() }}</span>
                        </div>

                        @if($service->orders()->exists())
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Последний заказ</span>
                                <span class="text-sm text-gray-900">{{ $service->orders()->latest()->first()->created_at->format('d.m.Y') }}</span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Дата создания</span>
                            <span class="text-sm text-gray-900">{{ $service->created_at->format('d.m.Y H:i') }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Последнее обновление</span>
                            <span class="text-sm text-gray-900">{{ $service->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Быстрые действия -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Быстрые действия</h2>
                    
                    <div class="space-y-3">
                        <!-- Переключение активности -->
                        <form method="POST" action="{{ route('admin.services.toggle-active', $service) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full {{ $service->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-md transition duration-200">
                                {{ $service->is_active ? 'Деактивировать' : 'Активировать' }}
                            </button>
                        </form>

                        <!-- Просмотр на сайте -->
                        @if($service->is_active)
                            <a href="{{ route('services.show', $service->slug) }}" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded-md transition duration-200">
                                Просмотреть на сайте
                            </a>
                        @endif

                        <!-- Редактирование -->
                        <a href="{{ route('admin.services.edit', $service) }}" class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white text-center px-4 py-2 rounded-md transition duration-200">
                            Редактировать
                        </a>

                        <!-- Удаление -->
                        @if($service->orders()->count() === 0)
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                                  onsubmit="return confirm('Вы уверены, что хотите удалить услугу \'{{ $service->name }}\'? Это действие нельзя отменить.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition duration-200">
                                    Удалить услугу
                                </button>
                            </form>
                        @else
                            <div class="w-full bg-gray-300 text-gray-500 text-center px-4 py-2 rounded-md cursor-not-allowed">
                                Удаление недоступно
                            </div>
                            <p class="text-xs text-gray-500 text-center">Нельзя удалить услугу с заказами</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>