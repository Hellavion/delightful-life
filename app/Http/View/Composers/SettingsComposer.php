<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Setting;

/**
 * Композер для передачи настроек во все представления
 */
class SettingsComposer
{
    /**
     * Привязка данных к представлению
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        // Создаем объект настроек с основными значениями
        $settings = (object) [
            'site_name' => setting('site_name', 'Delightful Life'),
            'artist_name' => setting('artist_name', 'Скрипник Анна'),
            'site_tagline' => setting('site_tagline', 'Искусство, которое вдохновляет'),
            'site_description' => setting('site_description', 'Создаю уникальные произведения искусства, воплощая ваши мечты в красках и формах'),
            'contact_email' => setting('contact_email', 'info@delightful-life.ru'),
            'contact_phone' => setting('contact_phone', '+7 (926) 786-86-41'),
            'social_instagram' => setting('social_instagram', 'https://www.instagram.com/delightful_life_art'),
            'social_telegram' => setting('social_telegram', 'https://t.me/AnnaSk_V'),
            'social_vk' => setting('social_vk'),
            'social_behance' => setting('social_behance'),
        ];

        $view->with('settings', $settings);
    }
}