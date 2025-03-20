<?php

namespace App\Filament\Resources\WebOrderItemResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\WebOrderItemResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\WebOrderItemResource\Api\Transformers\WebOrderItemTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = WebOrderItemResource::class;


    /**
     * Show WebOrderItem
     *
     * @param Request $request
     * @return WebOrderItemTransformer
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

        return new WebOrderItemTransformer($query);
    }
}
