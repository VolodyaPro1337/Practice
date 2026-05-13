<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Биоклиматические перголы',
                'slug' => 'bioclimatic-pergolas',
                'description' => 'Умная солнцезащита с поворотными алюминиевыми ламелями.',
                'system_code' => 'Система S-01',
                'sort_order' => 1,
            ],
            [
                'name' => 'Маркизы',
                'slug' => 'awnings',
                'description' => 'Динамичная тень для современных фасадов.',
                'sort_order' => 2,
            ],
            [
                'name' => 'ZIP Экраны',
                'slug' => 'zip-screens',
                'description' => 'Ветроустойчивая вертикальная защита.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Электрокарнизы Roskarniz',
                'slug' => 'electric-curtains',
                'description' => 'Бесшумная и плавная автоматизация для интерьерного текстиля.',
                'system_code' => 'Интерьерная Линия',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
