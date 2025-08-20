<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Портретная живопись',
                'slug' => 'portretnaya-zhivopis',
                'description' => 'Создание индивидуальных портретов маслом или акрилом',
                'process_description' => 'Консультация → Эскиз → Проработка → Живопись → Детализация',
                'price_from' => 25000,
                'price_to' => 80000,
                'pricing_type' => 'range',
                'duration' => '2-4 недели',
                'features' => ['Консультация', 'Эскизы', 'Поэтапное согласование', 'Оформление'],
                'sort_order' => 1,
            ],
            [
                'name' => 'Книжная иллюстрация',
                'slug' => 'knizhnaya-illustraciya',
                'description' => 'Иллюстрации для книг, журналов и изданий',
                'process_description' => 'Анализ текста → Концепция → Скетчи → Чистовик',
                'price_from' => 8000,
                'price_to' => 25000,
                'pricing_type' => 'range',
                'duration' => '1-3 недели',
                'features' => ['Концепт-арт', 'Цветовые эскизы', 'Итоговая иллюстрация', 'Файлы в высоком разрешении'],
                'sort_order' => 2,
            ],
            [
                'name' => 'Цифровой дизайн',
                'slug' => 'cifrovoj-dizajn',
                'description' => 'Логотипы, брендинг, веб-дизайн',
                'process_description' => 'Бриф → Исследование → Концепция → Разработка → Презентация',
                'price_from' => 15000,
                'price_to' => 50000,
                'pricing_type' => 'range',
                'duration' => '1-2 недели',
                'features' => ['Исследование рынка', 'Несколько вариантов', 'Файлы в разных форматах', 'Гайдлайны'],
                'sort_order' => 3,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
