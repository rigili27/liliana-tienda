<?php
namespace App\Filament\Resources\WebOrderResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\WebOrderResource;
use App\Filament\Resources\WebOrderResource\Api\Transformers\WebOrderTransformer;
use App\Models\WebOrder;

class PaginationHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = WebOrderResource::class;

    public static bool $public = true;

    /**
     * List of WebOrder
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

        // return WebOrderTransformer::collection($query);

        $query = WebOrder::all();
        return WebOrderTransformer::collection($query);
    }
}
