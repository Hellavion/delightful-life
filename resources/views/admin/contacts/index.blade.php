<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обращения клиентов - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к дашборду
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Обращения клиентов</h1>
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Статистика -->
                <div class="mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Всего обращений</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['total'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Непрочитанные</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['unread'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Без ответа</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['unreplied'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Сегодня</dt>
                                        <dd class="text-lg font-medium text-gray-900">{{ $stats['today'] }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Фильтры -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <form method="GET" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-0">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Поиск</label>
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   placeholder="Имя, email или тема обращения"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div class="w-48">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Тип обращения</label>
                            <select name="type" 
                                    id="type"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Все типы</option>
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}" @selected(request('type') === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-36">
                            <label for="is_read" class="block text-sm font-medium text-gray-700 mb-1">Прочитано</label>
                            <select name="is_read" 
                                    id="is_read"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Все</option>
                                <option value="1" @selected(request('is_read') === '1')>Прочитанные</option>
                                <option value="0" @selected(request('is_read') === '0')>Непрочитанные</option>
                            </select>
                        </div>

                        <div class="w-36">
                            <label for="is_replied" class="block text-sm font-medium text-gray-700 mb-1">Отвечено</label>
                            <select name="is_replied" 
                                    id="is_replied"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Все</option>
                                <option value="1" @selected(request('is_replied') === '1')>С ответом</option>
                                <option value="0" @selected(request('is_replied') === '0')>Без ответа</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                                Фильтр
                            </button>
                            <a href="{{ route('admin.contacts.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Сбросить
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Массовые действия -->
                @if($contacts->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                    <form id="bulk-action-form" method="POST" action="{{ route('admin.contacts.bulk-action') }}">
                        @csrf
                        <div class="flex items-center gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="select-all" class="ml-2 text-sm text-gray-700">Выбрать все</label>
                            </div>
                            
                            <select name="action" required class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Выберите действие</option>
                                <option value="mark_read">Пометить как прочитанные</option>
                                <option value="mark_unread">Пометить как непрочитанные</option>
                                <option value="mark_replied">Пометить как отвеченные</option>
                                <option value="mark_unreplied">Пометить как неотвеченные</option>
                                <option value="delete">Удалить</option>
                            </select>
                            
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors"
                                    onclick="return confirm('Вы уверены, что хотите выполнить это действие?')">
                                Выполнить
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Таблица обращений -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        <input type="checkbox" id="table-select-all" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Клиент
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Тема
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Тип
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Статус
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Дата
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Действия
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($contacts as $contact)
                                    <tr class="hover:bg-gray-50 {{ !$contact->is_read ? 'bg-blue-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" 
                                                   name="contacts[]" 
                                                   value="{{ $contact->id }}" 
                                                   form="bulk-action-form"
                                                   class="contact-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if(!$contact->is_read)
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $contact->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $contact->email }}
                                                    </div>
                                                    @if($contact->phone)
                                                        <div class="text-sm text-gray-500">
                                                            {{ $contact->phone }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                                {{ $contact->subject }}
                                            </div>
                                            <div class="text-sm text-gray-500 max-w-xs truncate">
                                                {{ Str::limit($contact->message, 60) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $typeColors = [
                                                    'general' => 'bg-gray-100 text-gray-800',
                                                    'order' => 'bg-blue-100 text-blue-800',
                                                    'collaboration' => 'bg-purple-100 text-purple-800',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $typeColors[$contact->type] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $types[$contact->type] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-1">
                                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $contact->is_read ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $contact->is_read ? 'Прочитано' : 'Не прочитано' }}
                                                </span>
                                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $contact->is_replied ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                                    {{ $contact->is_replied ? 'Отвечено' : 'Без ответа' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $contact->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.contacts.show', $contact) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    Просмотр
                                                </a>
                                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Вы уверены, что хотите удалить это обращение?')">
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <div class="text-lg font-medium">Обращения не найдены</div>
                                            <p class="mt-1">Попробуйте изменить параметры поиска</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($contacts->hasPages())
                        <div class="bg-white px-6 py-3 border-t border-gray-200">
                            {{ $contacts->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Обработка выбора всех чекбоксов
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.contact-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.getElementById('table-select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.contact-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Проверка, выбраны ли все чекбоксы
        document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('.contact-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.contact-checkbox:checked');
                
                const selectAllMain = document.getElementById('select-all');
                const selectAllTable = document.getElementById('table-select-all');
                
                if (checkedCheckboxes.length === allCheckboxes.length) {
                    selectAllMain.checked = true;
                    selectAllTable.checked = true;
                } else {
                    selectAllMain.checked = false;
                    selectAllTable.checked = false;
                }
            });
        });
    </script>
</body>
</html>