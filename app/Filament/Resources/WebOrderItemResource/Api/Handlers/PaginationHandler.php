<?php
namespace App\Filament\Resources\WebOrderItemResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\WebOrderItemResource;
use App\Filament\Resources\WebOrderItemResource\Api\Transformers\WebOrderItemTransformer;
use App\Models\WebOrderItem;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = WebOrderItemResource::class;

    public static bool $public = true;

    /**
     * List of WebOrderItem
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function handler()
    {
        // $query = static::getEloquentQuery();

        // $query = QueryBuilder::for($query)
        // ->allowedFields($this->getAllowedFields() ?? [])
        // ->allowedSorts($this->getAllowedSorts() ?? [])
        // ->allowedFilters($this->getAllowedFilters() ?? [])
        // ->allowedIncludes($this->getAllowedIncludes() ?? [])
        // ->paginate(request()->query('per_page'))
        // ->appends(request()->query());

        // return WebOrderItemTransformer::collection($query);

        $query = WebOrderItem::all();
        return WebOrderItemTransformer::collection($query);
    }
}
