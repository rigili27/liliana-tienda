<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Business extends Model
{
    protected $fillable = [
        'id',
        'name',
        'desktop_logo_url',
        'mobile_logo_url',
    ];

    protected static function booted()
    {
        // Eliminar imágenes cuando se actualiza el modelo y cambian las imágenes
        static::updating(function (Business $business) {
            $original = $business->getOriginal(); // Obtener los valores antes de la actualización

            if ($original['desktop_logo_url'] !== $business->desktop_logo_url) {
                Log::info("Updating - Eliminando imagen antigua: public/{$original['desktop_logo_url']}");
                Storage::disk('public')->delete($original['desktop_logo_url']);
            }

            if ($original['mobile_logo_url'] !== $business->mobile_logo_url) {
                Log::info("Updating - Eliminando imagen antigua: public/{$original['mobile_logo_url']}");
                Storage::disk('public')->delete($original['mobile_logo_url']);
            }
        });

        // Eliminar imágenes cuando se borra el modelo
        static::deleted(function (Business $business) {
            Log::info("Deleted - Eliminando imágenes de: public/{$business->desktop_logo_url} y {$business->mobile_logo_url}");

            Storage::disk('public')->delete($business->desktop_logo_url);
            Storage::disk('public')->delete($business->mobile_logo_url);
        });
    }
}
