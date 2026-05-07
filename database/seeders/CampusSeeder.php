<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        $campuses = [
            [
                'name' => 'ISUFST - Main Tiwi Campus',
                'code' => 'TAWI',
                'address' => 'Tiwi, Albay',
            ],
            [
                'name' => 'ISUFST - Dingle Campus',
                'code' => 'DING',
                'address' => 'Dingle, Iloilo',
            ],
            [
                'name' => 'ISUFST - San Enrique Campus',
                'code' => 'SENR',
                'address' => 'San Enrique, Iloilo',
            ],
            [
                'name' => 'ISUFST - Dumangas Campus',
                'code' => 'DUMG',
                'address' => 'Dumangas, Iloilo',
            ],
            [
                'name' => 'ISUFST - Main Poblacion Campus',
                'code' => 'POBL',
                'address' => 'Poblacion, Iloilo',
            ],
            [
                'name' => 'ISUFST - Barotac Nuevo Campus',
                'code' => 'BNUE',
                'address' => 'Barotac Nuevo, Iloilo',
            ],
        ];

        foreach ($campuses as $campus) {
            Campus::create($campus);
        }
    }
}
