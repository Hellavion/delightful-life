<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Сидер для создания начальных настроек сайта
 */
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Общие настройки
            [
                'key' => 'site_name',
                'value' => 'Мой художественный сайт',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Название сайта'
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Искусство, которое вдохновляет',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Слоган сайта'
            ],
            [
                'key' => 'site_description',
                'value' => 'Персональный сайт художника. Портфолио, услуги, заказы.',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Описание сайта'
            ],
            [
                'key' => 'artist_name',
                'value' => 'Имя Художника',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Имя художника'
            ],
            [
                'key' => 'site_maintenance',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'description' => 'Режим технических работ'
            ],
            
            // Контактная информация
            [
                'key' => 'contact_email',
                'value' => 'contact@example.com',
                'type' => 'email',
                'group' => 'contact',
                'description' => 'Email для связи'
            ],
            [
                'key' => 'contact_phone',
                'value' => '+7 (900) 123-45-67',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Телефон для связи'
            ],
            [
                'key' => 'contact_address',
                'value' => 'г. Москва, ул. Примерная, д. 1',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Адрес студии'
            ],
            [
                'key' => 'working_hours',
                'value' => 'Пн-Пт: 10:00-19:00',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Часы работы'
            ],
            
            // Социальные сети
            [
                'key' => 'social_instagram',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Instagram URL'
            ],
            [
                'key' => 'social_telegram',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Telegram URL'
            ],
            [
                'key' => 'social_vk',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'description' => 'ВКонтакте URL'
            ],
            [
                'key' => 'social_behance',
                'value' => '',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Behance URL'
            ],
            
            // SEO настройки
            [
                'key' => 'meta_keywords',
                'value' => 'художник, искусство, портрет, живопись, заказ',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Ключевые слова (через запятую)'
            ],
            [
                'key' => 'meta_author',
                'value' => 'Имя Художника',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Автор сайта'
            ],
            [
                'key' => 'google_analytics',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Google Analytics ID'
            ],
            [
                'key' => 'yandex_metrica',
                'value' => '',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Яндекс.Метрика ID'
            ],
            
            // Портфолио
            [
                'key' => 'portfolio_items_per_page',
                'value' => '12',
                'type' => 'number',
                'group' => 'portfolio',
                'description' => 'Количество работ на странице'
            ],
            [
                'key' => 'portfolio_featured_count',
                'value' => '6',
                'type' => 'number',
                'group' => 'portfolio',
                'description' => 'Количество рекомендуемых работ на главной'
            ],
            [
                'key' => 'portfolio_watermark',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'portfolio',
                'description' => 'Добавлять водяной знак на изображения'
            ],
            
            // Услуги
            [
                'key' => 'services_consultation_price',
                'value' => '2000',
                'type' => 'number',
                'group' => 'services',
                'description' => 'Стоимость консультации (руб.)'
            ],
            [
                'key' => 'services_min_order_amount',
                'value' => '5000',
                'type' => 'number',
                'group' => 'services',
                'description' => 'Минимальная сумма заказа (руб.)'
            ],
            [
                'key' => 'services_deposit_percent',
                'value' => '50',
                'type' => 'number',
                'group' => 'services',
                'description' => 'Размер предоплаты (%)'
            ],
            [
                'key' => 'services_working_days',
                'value' => '14',
                'type' => 'number',
                'group' => 'services',
                'description' => 'Стандартный срок выполнения заказа (дни)'
            ]
        ];

        foreach ($settings as $settingData) {
            Setting::updateOrCreate(
                ['key' => $settingData['key']],
                $settingData
            );
        }
    }
}
