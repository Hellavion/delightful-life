<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление услугами - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к дашборду
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Управление услугами</h1>
                </div>
                
                <div class="flex items-center space-x-4">
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Уведомления -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Заголовок и кнопка добавления -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Список услуг</h2>
                    <p class="text-sm text-gray-600 mt-1">Управление услугами, ценами и описаниями</p>
                </div>
                
                <a href="{{ route('admin.services.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                    Добавить услугу
                </a>
            </div>
        </div>

        <!-- Статистика -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Всего услуг</div>
                <div class="text-2xl font-bold text-gray-900">{{ $services->total() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Активные</div>
                <div class="text-2xl font-bold text-green-600">{{ $services->where('is_active', true)->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Неактивные</div>
                <div class="text-2xl font-bold text-orange-600">{{ $services->where('is_active', false)->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm font-medium text-gray-500">Со связанными заказами</div>
                <div class="text-2xl font-bold text-blue-600">{{ $services->filter(function($service) { return $service->orders_count > 0; })->count() }}</div>
            </div>
        </div>

        <!-- Список услуг -->
        <div class="bg-white rounded-lg shadow">
            @if($services->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Услуга
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Цена
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Сроки
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Статус
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Порядок
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Заказы
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($services as $service)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($service->description, 100) }}</div>
                                            <div class="text-xs text-gray-400 mt-1">{{ $service->slug }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($service->pricing_type === 'fixed' && $service->price_from)
                                                {{ number_format($service->price_from, 0, ',', ' ') }} ₽
                                            @elseif($service->pricing_type === 'range' && $service->price_from && $service->price_to)
                                                {{ number_format($service->price_from, 0, ',', ' ') }} - {{ number_format($service->price_to, 0, ',', ' ') }} ₽
                                            @else
                                                <span class="text-gray-500">Индивидуально</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            @if($service->pricing_type === 'fixed')
                                                Фиксированная
                                            @elseif($service->pricing_type === 'range')
                                                Диапазон
                                            @else
                                                Индивидуальная
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $service->duration ?? 'Не указано' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $service->is_active ? 'Активна' : 'Неактивна' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $service->sort_order }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @if($service->orders_count > 0)
                                                <span class="text-blue-600 font-medium">{{ $service->orders_count }}</span>
                                            @else
                                                <span class="text-gray-400">0</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Просмотр -->
                                            <a href="{{ route('admin.services.show', $service) }}" 
                                               class="text-blue-600 hover:text-blue-900" 
                                               title="Просмотр">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            <!-- Редактирование -->
                                            <a href="{{ route('admin.services.edit', $service) }}" 
                                               class="text-yellow-600 hover:text-yellow-900" 
                                               title="Редактировать">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>

                                            <!-- Переключение активности -->
                                            <form method="POST" action="{{ route('admin.services.toggle-active', $service) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="{{ $service->is_active ? 'text-orange-600 hover:text-orange-900' : 'text-green-600 hover:text-green-900' }}" 
                                                        title="{{ $service->is_active ? 'Деактивировать' : 'Активировать' }}">
                                                    @if($service->is_active)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>

                                            <!-- Удаление -->
                                            @if($service->orders_count === 0)
                                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" 
                                                      class="inline"
                                                      onsubmit="return confirm('Вы уверены, что хотите удалить услугу \'{{ $service->name }}\'?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900" 
                                                            title="Удалить">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400" title="Нельзя удалить услугу с заказами">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Пагинация -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $services->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="text-gray-400 text-lg mb-4">Услуги не найдены</div>
                    <a href="{{ route('admin.services.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition duration-200">
                        Создать первую услугу
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>