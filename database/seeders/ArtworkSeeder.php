<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder для создания тестовых произведений искусства
 */
class ArtworkSeeder extends Seeder
{
    /**
     * Запустить посев базы данных
     */
    public function run(): void
    {
        $artworks = [
            [
                'title' => 'Закат над морем',
                'slug' => 'zakat-nad-morem-' . now()->timestamp,
                'description' => 'Прекрасный закат над морем, выполненный в импрессионистическом стиле.',
                'technique' => 'Масло на холсте',
                'year' => 2023,
                'width' => 60,
                'height' => 80,
                'price' => 25000,
                'is_available' => true,
                'is_featured' => true,
                'categories' => ['Живопись']
            ],
            [
                'title' => 'Портрет девушки',
                'slug' => 'portret-devushki-' . now()->timestamp,
                'description' => 'Реалистичный портрет молодой девушки.',
                'technique' => 'Акрил на холсте',
                'year' => 2023,
                'width' => 40,
                'height' => 50,
                'price' => 30000,
                'is_available' => true,
                'is_featured' => false,
                'categories' => ['Живопись', 'Портреты']
            ],
            [
                'title' => 'Горный пейзаж',
                'slug' => 'gornyj-pejzazh-' . now()->timestamp,
                'description' => 'Величественные горы в утреннем тумане.',
                'technique' => 'Акварель',
                'year' => 2022,
                'width' => 30,
                'height' => 40,
                'price' => 15000,
                'is_available' => true,
                'is_featured' => true,
                'categories' => ['Живопись', 'Пейзажи']
            ],
            [
                'title' => 'Абстрактная композиция',
                'slug' => 'abstraktnaya-kompoziciya-' . now()->timestamp,
                'description' => 'Современная абстрактная работа с яркими цветами.',
                'technique' => 'Смешанная техника',
                'year' => 2024,
                'width' => 70,
                'height' => 100,
                'price' => 45000,
                'is_available' => false,
                'is_featured' => false,
                'categories' => ['Живопись', 'Абстракция']
            ],
            [
                'title' => 'Иллюстрация к сказке',
                'slug' => 'illyustraciya-k-skazke-' . now()->timestamp,
                'description' => 'Детская иллюстрация для книги сказок.',
                'technique' => 'Цифровая живопись',
                'year' => 2023,
                'width' => null,
                'height' => null,
                'price' => 8000,
                'is_available' => true,
                'is_featured' => false,
                'categories' => ['Иллюстрация']
            ]
        ];

        foreach ($artworks as $artworkData) {
            $categories = $artworkData['categories'];
            unset($artworkData['categories']);
            
            $artwork = Artwork::create($artworkData);
            
            // Привязка категорий
            foreach ($categories as $categoryName) {
                $category = Category::where('name', $categoryName)->first();
                if ($category) {
                    $artwork->categories()->attach($category->id);
                }
            }
        }
    }
}
