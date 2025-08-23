<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель - Dashboard</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Административная панель</h1>
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
            <div class="border-4 border-dashed border-gray-200 rounded-lg p-8">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        🎨 Добро пожаловать в админку сайта художника!
                    </h2>
                    
                    <p class="text-gray-600 mb-8">
                        Здесь вы сможете управлять портфолио, услугами, заказами и контентом сайта.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Портфолио</h3>
                            <p class="text-gray-600 text-sm mb-4">Управление работами и галереей</p>
                            <a href="{{ route('admin.artworks.index') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                                Управлять портфолио
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Услуги</h3>
                            <p class="text-gray-600 text-sm mb-4">Управление услугами и ценами</p>
                            <a href="{{ route('admin.services.index') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                                Управлять услугами
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Заказы</h3>
                            <p class="text-gray-600 text-sm mb-4">Обработка заказов клиентов</p>
                            <a href="{{ route('admin.orders.index') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                                Управлять заказами
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Новости</h3>
                            <p class="text-gray-600 text-sm mb-4">Управление статьями и новостями</p>
                            <a href="{{ route('admin.news.index') }}" 
                               class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200 inline-block">
                                Управлять новостями
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Контакты</h3>
                            <p class="text-gray-600 text-sm mb-4">Обработка обращений клиентов</p>
                            <a href="{{ route('admin.contacts.index') }}" 
                               class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200 inline-block">
                                Управлять обращениями
                            </a>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Настройки</h3>
                            <p class="text-gray-600 text-sm mb-4">Общие настройки сайта</p>
                            <a href="{{ route('admin.settings.index') }}" 
                               class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200 inline-block">
                                Настройки сайта
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center py-4 text-sm text-gray-500">
        Административная панель для сайта художника - v1.0.0
    </div>
</body>
</html>