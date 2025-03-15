<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Hero extends Model
{
    protected $fillable = [
        'id',
        'name',
        'image_url',
    ];

    protected static function booted()
    {
        // Eliminar imágen cuando se actualiza el modelo y cambian las imágenes
        static::updating(function (Hero $hero) {
            $original = $hero->getOriginal(); // Obtener los valores antes de la actualización

            if ($original['image_url'] !== $hero->image_url) {
                Log::info("Updating - Eliminando imagen antigua: public/{$original['image_url']}");
                Storage::disk('public')->delete($original['image_url']);
            }

            
        });

        // Eliminar imágenes cuando se borra el modelo
        static::deleted(function (Hero $hero) {
            Log::info("Deleted - Eliminando imágen de: public/{$hero->image_url}");

            Storage::disk('public')->delete($hero->image_url);
        });
    }
}
