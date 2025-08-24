<footer class="bg-gray-800 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-6 sm:mb-8">
            <!-- Контактная информация -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Контакты</h3>
                @if($settings->contact_email)
                <p class="mb-2">
                    <span class="text-gray-400">Email:</span>
                    <a href="mailto:{{ $settings->contact_email }}" class="hover:text-indigo-400 transition">
                        {{ $settings->contact_email }}
                    </a>
                </p>
                @endif
                @if($settings->contact_phone)
                <p class="mb-2">
                    <span class="text-gray-400">Телефон:</span>
                    <a href="tel:{{ $settings->contact_phone }}" class="hover:text-indigo-400 transition">
                        {{ $settings->contact_phone }}
                    </a>
                </p>
                @endif
                @if(setting('contact_address'))
                <p class="mb-2">
                    <span class="text-gray-400">Адрес:</span>
                    {{ setting('contact_address') }}
                </p>
                @endif
                @if(setting('working_hours'))
                <p class="text-gray-400">{{ setting('working_hours') }}</p>
                @endif
            </div>

            <!-- Социальные сети -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Социальные сети</h3>
                <div class="flex space-x-4">
                    @if($settings->social_instagram)
                    <a href="{{ $settings->social_instagram }}" target="_blank" class="hover:text-indigo-400 transition">
                        Instagram
                    </a>
                    @endif
                    @if($settings->social_telegram)
                    <a href="{{ $settings->social_telegram }}" target="_blank" class="hover:text-indigo-400 transition">
                        Telegram
                    </a>
                    @endif
                    @if($settings->social_vk)
                    <a href="{{ $settings->social_vk }}" target="_blank" class="hover:text-indigo-400 transition">
                        ВКонтакте
                    </a>
                    @endif
                    @if($settings->social_behance)
                    <a href="{{ $settings->social_behance }}" target="_blank" class="hover:text-indigo-400 transition">
                        Behance
                    </a>
                    @endif
                </div>
            </div>

            <!-- О художнике -->
            <div>
                <h3 class="text-lg font-semibold mb-4">{{ $settings->artist_name ?? 'Художник' }}</h3>
                <p class="text-gray-400">{{ $settings->site_name ?? 'Художественная студия' }}</p>
            </div>
        </div>
        
        <div class="border-t border-gray-700 pt-6 sm:pt-8 text-center">
            <p class="text-sm sm:text-base">&copy; {{ date('Y') }} {{ $settings->site_name ?? 'Художественная студия' }}. Все права защищены.</p>
        </div>
    </div>
</footer>