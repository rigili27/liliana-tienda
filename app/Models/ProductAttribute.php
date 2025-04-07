<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'attribute_id'];

    protected $casts = [
        // 'attributes' => 'array', // Convierte JSON automáticamente a un array PHP
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Traducciones de los atributos
    // public static array $attributeTranslations = [
    //     'new' => 'Nuevo',
    //     'on_sale' => 'En oferta',
    //     'featured' => 'Destacado',
    //     'limited_edition' => 'Edición Limitada',
    //     'bestseller' => 'Más Vendido',
    //     'exclusive' => 'Exclusivo',
    // ];

    // public static array $attributeColors = [
    //     'new' => 'green',         // Verde para "Nuevo"
    //     'on_sale' => 'red',        // Rojo para "En oferta"
    //     'featured' => 'yellow',    // Amarillo para "Destacado"
    //     'limited_edition' => 'purple', // Púrpura para "Edición Limitada"
    //     'bestseller' => 'blue',    // Azul para "Más Vendido"
    //     'exclusive' => 'pink',     // Rosa para "Exclusivo"
    // ];

    // public function getTranslatedAttributesWithColors()
    // {
    //     // Decodificar JSON si es un string
    //     $attributes = $this->attributes['attributes'] ?? [];

    //     if (is_string($attributes)) {
    //         $attributes = json_decode($attributes, true) ?? [];
    //     }

    //     if (empty($attributes) || !is_array($attributes)) {
    //         return [];
    //     }

    //     return collect($attributes)
    //         ->filter(fn($value) => $value === true)
    //         ->map(fn($_, $key) => [
    //             'name' => self::$attributeTranslations[$key] ?? ucfirst($key),
    //             'color' => self::$attributeColors[$key] ?? 'bg-gray-500',
    //         ])
    //         ->values()
    //         ->toArray();
    // }
}
