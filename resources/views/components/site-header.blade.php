@props(['currentRoute' => null])

<header class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4 md:py-6">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 truncate">
                <a href="{{ route('home') }}" class="block text-gray-900 no-underline hover:text-gray-900 focus:text-gray-900 active:text-gray-900" style="color: inherit;">
                    {{ $settings->site_name ?? 'Художественная студия' }}
                </a>
            </h1>
            
            <!-- Мобильное меню кнопка -->
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
            <!-- Десктопная навигация -->
            <nav class="hidden md:flex md:space-x-8">
                <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }} px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Главная</a>
                <a href="{{ route('portfolio.index') }}" class="{{ str_starts_with($currentRoute, 'portfolio') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }} px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Портфолио</a>
                <a href="{{ route('services.index') }}" class="{{ str_starts_with($currentRoute, 'services') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }} px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Услуги</a>
                <a href="{{ route('news.index') }}" class="{{ str_starts_with($currentRoute, 'news') ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }} px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Новости</a>
                <a href="{{ route('contact.index') }}" class="{{ $currentRoute === 'contact.index' ? 'text-indigo-600 font-semibold' : 'text-gray-700 hover:text-indigo-600' }} px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Контакты</a>
            </nav>
        </div>
        
        <!-- Мобильное меню -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                <a href="{{ route('home') }}" class="{{ $currentRoute === 'home' ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">Главная</a>
                <a href="{{ route('portfolio.index') }}" class="{{ str_starts_with($currentRoute, 'portfolio') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">Портфолио</a>
                <a href="{{ route('services.index') }}" class="{{ str_starts_with($currentRoute, 'services') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">Услуги</a>
                <a href="{{ route('news.index') }}" class="{{ str_starts_with($currentRoute, 'news') ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">Новости</a>
                <a href="{{ route('contact.index') }}" class="{{ $currentRoute === 'contact.index' ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} block px-3 py-2 rounded-md text-base font-medium transition duration-150 ease-in-out">Контакты</a>
            </div>
        </div>
    </div>
</header>

<script>
    // Мобильное меню
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        
        if (button && menu) {
            button.addEventListener('click', function() {
                const icon = button.querySelector('svg path');
                
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                    // Изменяем иконку на крестик
                    icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
                } else {
                    menu.classList.add('hidden');
                    // Возвращаем иконку гамбургера
                    icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                }
            });

            // Закрытие меню при клике на ссылку
            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    const icon = button.querySelector('svg path');
                    menu.classList.add('hidden');
                    icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
                });
            });
        }
    });
</script>