<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты - Delightful Life</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <h1 class="text-3xl font-bold text-gray-900">Delightful Life</h1>
                <nav class="space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">Главная</a>
                    <a href="{{ route('portfolio.index') }}" class="text-gray-700 hover:text-indigo-600">Портфолио</a>
                    <a href="{{ route('services.index') }}" class="text-gray-700 hover:text-indigo-600">Услуги</a>
                    <a href="{{ route('news.index') }}" class="text-gray-700 hover:text-indigo-600">Новости</a>
                    <a href="{{ route('contact.index') }}" class="text-indigo-600 font-semibold">Контакты</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-center mb-12">Свяжитесь со мной</h1>
            
            @if(session('success'))
            <div class="max-w-2xl mx-auto mb-8">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Контактная форма -->
                <div class="bg-white p-8 rounded-lg shadow">
                    <h2 class="text-2xl font-bold mb-6">Отправьте сообщение</h2>
                    
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Имя *</label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Телефон</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Тип обращения *</label>
                            <select id="type" 
                                    name="type" 
                                    required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('type') border-red-500 @enderror">
                                <option value="">Выберите тип обращения</option>
                                <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>Общий вопрос</option>
                                <option value="order" {{ old('type') === 'order' ? 'selected' : '' }}>Заказ</option>
                                <option value="collaboration" {{ old('type') === 'collaboration' ? 'selected' : '' }}>Сотрудничество</option>
                            </select>
                            @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Тема *</label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('subject') border-red-500 @enderror">
                            @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Сообщение *</label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="5" 
                                      required 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 transition font-medium">
                            Отправить сообщение
                        </button>
                    </form>
                </div>

                <!-- Контактная информация -->
                <div class="space-y-8">
                    <div class="bg-white p-8 rounded-lg shadow">
                        <h2 class="text-2xl font-bold mb-6">Контактная информация</h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-lg font-medium text-gray-900">Email</p>
                                    <p class="text-gray-600">hello@delightful-life.com</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-lg font-medium text-gray-900">Телефон</p>
                                    <p class="text-gray-600">+7 (999) 123-45-67</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-lg font-medium text-gray-900">Время работы</p>
                                    <p class="text-gray-600">Пн-Пт: 10:00 - 19:00<br>Сб-Вс: 12:00 - 17:00</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-lg font-medium text-gray-900">Студия</p>
                                    <p class="text-gray-600">г. Москва<br>Встречи по предварительной записи</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-lg shadow">
                        <h3 class="text-xl font-bold mb-4">Социальные сети</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-indigo-600 transition">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.004 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.326-1.297L3.905 14.41c-.49-.653-.49-1.569 0-2.222l1.218-1.281c.878-.807 2.029-1.297 3.326-1.297.653 0 1.281.163 1.828.49L12 11.823l1.723-1.723c.547-.327 1.175-.49 1.828-.49 1.297 0 2.448.49 3.326 1.297l1.218 1.281c.49.653.49 1.569 0 2.222l-1.218 1.281c-.878.807-2.029 1.297-3.326 1.297-.653 0-1.281-.163-1.828-.49L12 13.175l-1.723 1.723c-.547.327-1.175.49-1.828.49z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600 transition">
                                <span class="sr-only">Telegram</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600 transition">
                                <span class="sr-only">Behance</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M0 7.5v9c0 .828.672 1.5 1.5 1.5h21c.828 0 1.5-.672 1.5-1.5v-9c0-.828-.672-1.5-1.5-1.5h-21C.672 6 0 6.672 0 7.5zM15.5 10h3v1h-3v-1zm-5.25 2.5c.69 0 1.25.56 1.25 1.25s-.56 1.25-1.25 1.25S9 14.44 9 13.75s.56-1.25 1.25-1.25zM5.25 9c.966 0 1.75.784 1.75 1.75S6.216 12.5 5.25 12.5 3.5 11.716 3.5 10.75 4.284 9 5.25 9z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Delightful Life. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>