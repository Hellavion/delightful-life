<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Живопись',
                'slug' => 'zhivopis',
                'description' => 'Картины маслом, акрилом, акварелью',
                'color' => '#E11D48',
                'sort_order' => 1,
            ],
            [
                'name' => 'Иллюстрация',
                'slug' => 'illustraciya',
                'description' => 'Книжная графика, editorial иллюстрации',
                'color' => '#7C3AED',
                'sort_order' => 2,
            ],
            [
                'name' => 'Цифровое искусство',
                'slug' => 'cifrovoe-iskusstvo',
                'description' => 'Цифровые работы, дизайн, концепт-арт',
                'color' => '#059669',
                'sort_order' => 3,
            ],
            [
                'name' => 'Портреты',
                'slug' => 'portrety',
                'description' => 'Портретная живопись на заказ',
                'color' => '#DC2626',
                'sort_order' => 4,
            ],
            [
                'name' => 'Пейзажи',
                'slug' => 'peyzazhi',
                'description' => 'Пейзажная живопись',
                'color' => '#16A34A',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
