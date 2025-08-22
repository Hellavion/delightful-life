<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление новостями - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
                        ← Назад к панели
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Управление новостями</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.news.create') }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
                        Добавить новость
                    </a>
                    
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200"
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
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
                    <div class="text-green-800">{{ session('success') }}</div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                @if($news->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($news as $item)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $item->title }}
                                    </h3>
                                    @if($item->excerpt)
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($item->excerpt, 120) }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ $item->created_at->format('d.m.Y H:i') }}</span>
                                        @if($item->is_published)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                                Опубликовано
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                                Черновик
                                            </span>
                                        @endif
                                        @if($item->is_featured)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                                Рекомендуемое
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.news.show', $item) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        Просмотр
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        Редактировать
                                    </a>
                                    <form method="POST" action="{{ route('admin.news.destroy', $item) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('Вы уверены, что хотите удалить эту новость?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $news->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-500 text-6xl mb-4">📰</div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Новостей пока нет</h3>
                        <p class="text-gray-600 mb-6">Создайте первую новость для вашего сайта</p>
                        <a href="{{ route('admin.news.create') }}" 
                           class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
                            Добавить новость
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>