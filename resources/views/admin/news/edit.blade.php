<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать новость - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('admin.news.index') }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
                        ← Назад к новостям
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Редактировать новость</h1>
                </div>
                
                <div class="flex items-center space-x-4">
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

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <div class="text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.news.update', $news) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Основная информация</h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Заголовок *
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title"
                               value="{{ old('title', $news->title) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               required>
                    </div>

                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                            Краткое описание
                        </label>
                        <textarea name="excerpt" 
                                  id="excerpt"
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('excerpt', $news->excerpt) }}</textarea>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Содержание *
                        </label>
                        <textarea name="content" 
                                  id="content"
                                  rows="10"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                  required>{{ old('content', $news->content) }}</textarea>
                    </div>

                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Изображение (URL)
                        </label>
                        <input type="url" 
                               name="featured_image" 
                               id="featured_image"
                               value="{{ old('featured_image', $news->featured_image) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                            Теги (через запятую)
                        </label>
                        <input type="text" 
                               name="tags" 
                               id="tags"
                               value="{{ old('tags', is_array($news->tags) ? implode(', ', $news->tags) : $news->tags) }}"
                               placeholder="тег1, тег2, тег3"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Настройки публикации</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_published" 
                                   id="is_published"
                                   value="1"
                                   {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                Опубликовать сразу
                            </label>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   id="is_featured"
                                   value="1"
                                   {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                Рекомендуемая новость
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Дата публикации
                        </label>
                        <input type="datetime-local" 
                               name="published_at" 
                               id="published_at"
                               value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-6">SEO настройки</h2>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-2">
                            SEO заголовок
                        </label>
                        <input type="text" 
                               name="seo_title" 
                               id="seo_title"
                               value="{{ old('seo_title', $news->seo_title) }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-2">
                            SEO описание
                        </label>
                        <textarea name="seo_description" 
                                  id="seo_description"
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('seo_description', $news->seo_description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.news.index') }}" 
                   class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                    Отмена
                </a>
                <button type="submit" 
                        class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition duration-200">
                    Обновить новость
                </button>
            </div>
        </form>
    </div>
</body>
</html>