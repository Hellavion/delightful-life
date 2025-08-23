<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки сайта - Административная панель</title>
    @vite(['resources/css/admin/base.css'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-purple-600 hover:text-purple-800 mr-4">
                        ← Назад к дашборду
                    </a>
                    <h1 class="text-xl font-semibold text-gray-900">Настройки сайта</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">
                        {{ Auth::guard('admin')->user()->name }}
                    </span>
                    
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

<div class="max-w-4xl mx-auto py-6 px-4">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Настройки сайта</h2>
        <p class="text-gray-600">Управление общими настройками сайта</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        @forelse($groups as $groupKey => $groupName)
            @if(isset($settingsByGroup[$groupKey]) && $settingsByGroup[$groupKey]->isNotEmpty())
                <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $groupName }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($settingsByGroup[$groupKey] as $setting)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $setting->description ?: $setting->key }}
                                </label>
                                
                                @switch($setting->type)
                                    @case('textarea')
                                        <textarea 
                                            name="settings[{{ $setting->key }}]" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                            rows="4"
                                        >{{ $setting->value }}</textarea>
                                        @break
                                    
                                    @case('boolean')
                                        <div class="mt-2">
                                            <label class="inline-flex items-center">
                                                <input 
                                                    type="checkbox"
                                                    name="settings[{{ $setting->key }}]"
                                                    value="1"
                                                    class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50"
                                                    {{ $setting->value ? 'checked' : '' }}
                                                />
                                                <span class="ml-2 text-sm text-gray-600">Включено</span>
                                            </label>
                                        </div>
                                        @break
                                    
                                    @case('email')
                                        <input 
                                            type="email"
                                            name="settings[{{ $setting->key }}]" 
                                            value="{{ $setting->value }}" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        />
                                        @break
                                    
                                    @case('url')
                                        <input 
                                            type="url"
                                            name="settings[{{ $setting->key }}]" 
                                            value="{{ $setting->value }}" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                            placeholder="https://example.com"
                                        />
                                        @break
                                    
                                    @case('number')
                                        <input 
                                            type="number"
                                            name="settings[{{ $setting->key }}]" 
                                            value="{{ $setting->value }}" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        />
                                        @break
                                    
                                    @default
                                        <input 
                                            type="text"
                                            name="settings[{{ $setting->key }}]" 
                                            value="{{ $setting->value }}" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                        />
                                @endswitch
                                
                                @error('settings.' . $setting->key)
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <div class="bg-gray-50 rounded-lg p-8 text-center">
                <div class="mx-auto h-12 w-12 text-gray-400 mb-4">⚙️</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Настройки не найдены</h3>
                <p class="text-gray-500 mb-4">Настройки будут созданы автоматически при запуске сидера.</p>
                <p class="text-sm text-gray-400">Выполните команду: php artisan db:seed --class=SettingsSeeder</p>
            </div>
        @endforelse

        @if(!$settingsByGroup->isEmpty())
            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="bg-purple-600 text-white px-6 py-3 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-200 inline-flex items-center"
                >
                    <span class="mr-2">✓</span>
                    Сохранить настройки
                </button>
            </div>
        @endif
    </form>
</div>

<div class="text-center py-4 text-sm text-gray-500">
    Настройки сайта - Административная панель v1.0.0
</div>

<style>
.space-y-8 > :not([hidden]) ~ :not([hidden]) {
    --tw-space-y-reverse: 0;
    margin-top: calc(2rem * calc(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(2rem * var(--tw-space-y-reverse));
}
</style>
</body>
</html>