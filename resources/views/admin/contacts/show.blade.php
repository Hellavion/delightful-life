<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обращение #{{ $contact->id }} - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.contacts.index') }}" class="text-purple-600 hover:text-purple-800">
                        ← Назад к списку обращений
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Обращение #{{ $contact->id }}</h1>
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

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Основная информация -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">Информация об обращении</h2>
                        <div class="flex items-center gap-2">
                            @if(!$contact->is_read)
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    Не прочитано
                                </span>
                            @endif
                            @if(!$contact->is_replied)
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                    Без ответа
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Имя клиента</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contact->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $contact->email }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $contact->email }}
                                </a>
                            </dd>
                        </div>
                        
                        @if($contact->phone)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Телефон</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="tel:{{ $contact->phone }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $contact->phone }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Тип обращения</dt>
                            <dd class="mt-1">
                                @php
                                    $typeColors = [
                                        'general' => 'bg-gray-100 text-gray-800',
                                        'order' => 'bg-blue-100 text-blue-800',
                                        'collaboration' => 'bg-purple-100 text-purple-800',
                                    ];
                                    $types = \App\Models\Contact::getTypes();
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $typeColors[$contact->type] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $types[$contact->type] }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Дата создания</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contact->created_at->format('d.m.Y H:i') }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Последнее обновление</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $contact->updated_at->format('d.m.Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Тема и сообщение -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Сообщение</h2>
                </div>
                
                <div class="px-6 py-4">
                    <div class="mb-4">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Тема</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $contact->subject }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 mb-2">Текст сообщения</dt>
                        <dd class="text-sm text-gray-900 whitespace-pre-wrap leading-relaxed p-4 bg-gray-50 rounded-lg">{{ $contact->message }}</dd>
                    </div>
                </div>
            </div>

            <!-- Заметки администратора -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Заметки администратора</h2>
                </div>
                
                <div class="px-6 py-4">
                    <form method="POST" action="{{ route('admin.contacts.update-notes', $contact) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Добавить или изменить заметки
                            </label>
                            <textarea 
                                name="admin_notes" 
                                id="admin_notes" 
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Введите заметки о данном обращении..."
                            >{{ $contact->admin_notes }}</textarea>
                        </div>
                        
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Сохранить заметки
                        </button>
                    </form>
                </div>
            </div>

            <!-- Действия -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Действия</h2>
                </div>
                
                <div class="px-6 py-4">
                    <div class="flex flex-wrap gap-4">
                        <!-- Создать заказ из обращения -->
                        <form method="POST" action="{{ route('admin.contacts.create-order', $contact) }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Создать заказ
                            </button>
                        </form>

                        <!-- Быстрый ответ по email -->
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Здравствуйте, {{ $contact->name }}!%0A%0AСпасибо за ваше обращение.%0A%0A" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                            </svg>
                            Ответить по email
                        </a>

                        <!-- Изменить статус прочтения -->
                        <form method="POST" action="{{ route('admin.contacts.toggle-read', $contact) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-{{ $contact->is_read ? 'gray' : 'green' }}-600 hover:bg-{{ $contact->is_read ? 'gray' : 'green' }}-700 text-white px-4 py-2 rounded-lg transition-colors">
                                {{ $contact->is_read ? 'Пометить как непрочитанное' : 'Пометить как прочитанное' }}
                            </button>
                        </form>

                        <!-- Изменить статус ответа -->
                        <form method="POST" action="{{ route('admin.contacts.toggle-replied', $contact) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-{{ $contact->is_replied ? 'gray' : 'purple' }}-600 hover:bg-{{ $contact->is_replied ? 'gray' : 'purple' }}-700 text-white px-4 py-2 rounded-lg transition-colors">
                                {{ $contact->is_replied ? 'Пометить как неотвеченное' : 'Пометить как отвеченное' }}
                            </button>
                        </form>

                        <!-- Удалить обращение -->
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors"
                                    onclick="return confirm('Вы уверены, что хотите удалить это обращение? Это действие нельзя отменить.')">
                                Удалить обращение
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" 
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif
</body>
</html>