<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $materials = [
            [
                'name' => 'Graphite Matte',
                'slug' => 'graphite-matte',
                'hex_color' => '#292524',
                'description' => 'Глубокий графитовый матовый финиш. Идеальный выбор для современных минималистичных фасадов.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Quartz Light',
                'slug' => 'quartz-light',
                'hex_color' => '#d6d3d1',
                'description' => 'Светлый кварцевый оттенок. Нежное отражение света для теплой архитектурной палитры.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Anodized Bronze',
                'slug' => 'anodized-bronze',
                'hex_color' => '#35251a',
                'description' => 'Анодированная бронза. Классический теплый тон с выразительной текстурой металла.',
                'sort_order' => 3,
            ],
        ];

        foreach ($materials as $material) {
            Material::create($material);
        }
    }
}
