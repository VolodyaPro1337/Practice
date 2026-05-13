<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'name' => 'Slim Track (25mm)',
                'slug' => 'slim-track-25mm',
                'description' => 'Наш фирменный профиль. Максимизирует естественное освещение за счет ультратонких рамок.',
                'max_span_mm' => 6000,
                'tags' => ['Хит Продаж', 'Макс. Теплоизоляция'],
                'is_best_seller' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Усиленный профиль',
                'slug' => 'reinforced-profile',
                'description' => 'Спроектирован для больших пролетов и высоких ветровых нагрузок. Усиленная конструкция.',
                'max_span_mm' => 8000,
                'tags' => ['Широкий Пролет'],
                'is_best_seller' => false,
                'sort_order' => 2,
            ],
            [
                'name' => 'Скрытый профиль',
                'slug' => 'hidden-profile',
                'description' => 'Скрытая интеграция в перекрытия пола и потолка. Создает бесшовный порог между интерьером и экстерьером.',
                'max_span_mm' => 5000,
                'tags' => ['Скрытая Рама'],
                'is_best_seller' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($profiles as $profile) {
            Profile::create($profile);
        }
    }
}
