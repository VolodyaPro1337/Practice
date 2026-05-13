<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Биоклиматическая пергола Premium',
                'slug' => 'bioclimatic-pergola-premium',
                'description' => 'Наша флагманская пергола с поворотными алюминиевыми ламелями. Максимальная автоматизация и интеграция с умным домом.',
                'short_description' => 'Умная солнцезащита с поворотными алюминиевыми ламелями.',
                'system_code' => 'S-01',
                'accent_color' => '#ffffff',
                'sort_order' => 1,
            ],
            [
                'category_id' => 2,
                'name' => 'Маркиза складная Luxury',
                'slug' => 'folding-awning-luxury',
                'description' => 'Высококлассная минималистичная маркиза с раздвижными руками. Графитовое покрытие ткани.',
                'short_description' => 'Динамичная тень для современных фасадов.',
                'sort_order' => 2,
            ],
            [
                'category_id' => 3,
                'name' => 'ZIP Экран Architectural',
                'slug' => 'zip-screen-architectural',
                'description' => 'Вертикальная ZIP-система, интегрированная в оконный профиль. Безупречная ветроустойчивость.',
                'short_description' => 'Ветроустойчивая вертикальная защита.',
                'sort_order' => 3,
            ],
            [
                'category_id' => 4,
                'name' => 'Электрокарниз Roskarniz Silent',
                'slug' => 'electric-curtain-roskarniz-silent',
                'description' => 'Бесшумный электрокарниз для интерьерного текстиля. Плавная автоматизация и поддержка умного дома.',
                'short_description' => 'Бесшумная и плавная автоматизация для интерьерного текстиля.',
                'system_code' => 'RK-S01',
                'sort_order' => 4,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
