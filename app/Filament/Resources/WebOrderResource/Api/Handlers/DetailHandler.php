<?php

namespace App\Filament\Resources\WebOrderResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\WebOrderResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\WebOrderResource\Api\Transformers\WebOrderTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = WebOrderResource::class;

    public static bool $public = true;
    
    /**
     * Show WebOrder
     *
     * @param Request $request
     * @return WebOrderTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new WebOrderTransformer($query);
    }
}
