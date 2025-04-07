<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = [
            ['name' => 'new', 'show_name' => 'Nuevo'],
            ['name' => 'offer', 'show_name' => 'En Oferta'],
            ['name' => 'bestseller', 'show_name' => 'Más Vendido'],
            ['name' => 'limited', 'show_name' => 'Edición Limitada'],
            ['name' => 'exclusive', 'show_name' => 'Exclusivo'],
            ['name' => 'recommended', 'show_name' => 'Recomendado'],
        ];

        foreach ($attributes as $attribute) {
            Attribute::firstOrCreate(['name' => $attribute['name']], $attribute);
        }
    }
}
