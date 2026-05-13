<?php

namespace Database\Seeders;

use App\Models\AutomationOption;
use Illuminate\Database\Seeder;

class AutomationOptionSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            [
                'name' => 'Управление App / WiFi',
                'slug' => 'smartphone-wifi',
                'description' => 'Интеграция с iOS & Android',
                'subtitle' => 'Интеграция с iOS & Android',
                'icon' => 'smartphone',
                'sort_order' => 1,
            ],
            [
                'name' => 'Датчик Солнца и Ветра',
                'slug' => 'sun-wind-sensor',
                'description' => 'Безопасность при шторме',
                'subtitle' => 'Безопасность при шторме',
                'icon' => 'routine',
                'sort_order' => 2,
            ],
            [
                'name' => 'LED Периметр',
                'slug' => 'led-perimeter',
                'description' => 'Регулируемая теплота DALI',
                'subtitle' => 'Регулируемая теплота DALI',
                'icon' => 'lightbulb',
                'sort_order' => 3,
            ],
        ];

        foreach ($options as $option) {
            AutomationOption::create($option);
        }
    }
}
