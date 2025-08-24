<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Проверка доступности функции setting будет выполнена в файле helpers
        if (!function_exists('setting')) {
            require_once app_path('helpers.php');
        }

        // Пробрасываем основные настройки во все представления
        try {
            $globalSettings = [
                'site_name' => Setting::get('site_name', 'Художественный сайт'),
                'site_tagline' => Setting::get('site_tagline', ''),
                'artist_name' => Setting::get('artist_name', ''),
                'contact_email' => Setting::get('contact_email', ''),
                'contact_phone' => Setting::get('contact_phone', ''),
                'social_instagram' => Setting::get('social_instagram', ''),
                'social_telegram' => Setting::get('social_telegram', ''),
                'social_vk' => Setting::get('social_vk', ''),
                'social_behance' => Setting::get('social_behance', ''),
            ];

            View::share('settings', (object) $globalSettings);
        } catch (\Exception $e) {
            // Если таблица настроек еще не создана, игнорируем ошибку
        }
    }
}
