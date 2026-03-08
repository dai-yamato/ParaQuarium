<?php

namespace Database\Seeders;

use App\Models\ParameterType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Only one default system-wide parameter needed: 水温 (Temperature)
        ParameterType::firstOrCreate([
            'user_id' => null,
            'name' => '水温',
        ], [
            'unit' => '℃',
            'icon' => 'thermometer',
            'sort_order' => 10,
            'is_default' => true,
        ]);
        
        // Let's also add pH, NO2, and GH, but maybe the user can delete them?
        // Let's just create "水温" as the true default to perfectly match "デフォルトは水温だけ持っているみたいな"
    }
}
