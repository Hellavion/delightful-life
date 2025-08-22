<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание заказа - Административная панель</title>
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
                    <h1 class="text-xl font-semibold text-gray-900">Создание заказа</h1>
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
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Создание заказа</h1>
                <p class="mt-2 text-gray-600">Добавление нового заказа в систему</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                Назад к списку
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.orders.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Левая колонка -->
            <div class="space-y-6">
                <!-- Информация о клиенте -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Информация о клиенте</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">
                                Имя клиента <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="client_name" 
                                   id="client_name"
                                   value="{{ old('client_name') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('client_name') border-red-500 @enderror">
                            @error('client_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="client_email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="client_email" 
                                   id="client_email"
                                   value="{{ old('client_email') }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('client_email') border-red-500 @enderror">
                            @error('client_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="client_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                Телефон
                            </label>
                            <input type="tel" 
                                   name="client_phone" 
                                   id="client_phone"
                                   value="{{ old('client_phone') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('client_phone') border-red-500 @enderror">
                            @error('client_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Детали заказа -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Детали заказа</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Услуга <span class="text-red-500">*</span>
                            </label>
                            <select name="service_id" 
                                    id="service_id"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('service_id') border-red-500 @enderror">
                                <option value="">Выберите услугу</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" 
                                            @selected(old('service_id') == $service->id)
                                            data-price="{{ $service->price_from }}">
                                        {{ $service->name }}
                                        @if($service->price_from)
                                            (от {{ number_format($service->price_from, 0, ',', ' ') }} ₽)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Описание заказа <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" 
                                      id="description"
                                      rows="4"
                                      required
                                      placeholder="Подробное описание того, что нужно сделать..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-1">
                                Размеры
                            </label>
                            <input type="text" 
                                   name="dimensions" 
                                   id="dimensions"
                                   value="{{ old('dimensions') }}"
                                   placeholder="Например: 30x40 см, A4, 1920x1080 px"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('dimensions') border-red-500 @enderror">
                            @error('dimensions')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">
                                Желаемые сроки
                            </label>
                            <input type="date" 
                                   name="deadline" 
                                   id="deadline"
                                   value="{{ old('deadline') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deadline') border-red-500 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая колонка -->
            <div class="space-y-6">
                <!-- Финансовая информация -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Финансовая информация</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                Стоимость (₽) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="price" 
                                   id="price"
                                   value="{{ old('price') }}"
                                   min="0"
                                   step="0.01"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deposit" class="block text-sm font-medium text-gray-700 mb-1">
                                Депозит (₽)
                            </label>
                            <input type="number" 
                                   name="deposit" 
                                   id="deposit"
                                   value="{{ old('deposit') }}"
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deposit') border-red-500 @enderror">
                            @error('deposit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="deposit_paid" 
                                       id="deposit_paid"
                                       value="1"
                                       @checked(old('deposit_paid'))
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="deposit_paid" class="ml-2 block text-sm text-gray-900">
                                    Депозит оплачен
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" 
                                       name="full_payment_received" 
                                       id="full_payment_received"
                                       value="1"
                                       @checked(old('full_payment_received'))
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="full_payment_received" class="ml-2 block text-sm text-gray-900">
                                    Полная оплата получена
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Статус и заметки -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Статус и заметки</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                                Статус <span class="text-red-500">*</span>
                            </label>
                            <select name="status" 
                                    id="status"
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status', 'pending') === $key)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Заметки администратора
                            </label>
                            <textarea name="notes" 
                                      id="notes"
                                      rows="3"
                                      placeholder="Внутренние заметки о заказе..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопки действий -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.orders.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors">
                Отмена
            </a>
            <button type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition-colors">
                Создать заказ
            </button>
        </div>
    </form>
</div>

<script>
// Автоматическое заполнение цены при выборе услуги
document.getElementById('service_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const priceInput = document.getElementById('price');
    const depositInput = document.getElementById('deposit');
    
    if (price && price > 0) {
        priceInput.value = price;
        // Автоматически рассчитываем депозит как 30% от цены
        depositInput.value = Math.round(price * 0.3);
    }
});

// Автоматический расчет депозита при изменении цены
document.getElementById('price').addEventListener('input', function() {
    const price = parseFloat(this.value) || 0;
    const depositInput = document.getElementById('deposit');
    
    if (price > 0) {
        depositInput.value = Math.round(price * 0.3);
    }
});
</script>
        </div>
    </div>
</body>
</html>